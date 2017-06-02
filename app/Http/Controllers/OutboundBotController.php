<?php namespace App\Http\Controllers;

use App\Answer;
use App\Conversation;
use App\CustomerList;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\OutboundBot;
use App\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Twilio\Rest\Client;
use Twilio\Twiml;

class OutboundBotController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$outbound_bots = OutboundBot::orderBy('id', 'desc')->paginate(10);

		return view('outbound_bots.index', compact('outbound_bots'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('outbound_bots.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$outbound_bot = new OutboundBot();

		$outbound_bot->name = $request->input("name");
        $outbound_bot->description = $request->input("description");
        $outbound_bot->phone_number = $request->input("phone_number");
        $outbound_bot->customer_list_id = $request->input("customer_list_id");

		$outbound_bot->save();

		return redirect()->route('outbound_bots.index')->with('message', 'Item created successfully.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$outbound_bot = OutboundBot::where('id', $id)->first();

		$questions = Question::where('bot_id', $id)->with('answers')->get();


		return view('outbound_bots.show', compact('outbound_bot', 'questions'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$outbound_bot = OutboundBot::findOrFail($id);

		return view('outbound_bots.edit', compact('outbound_bot'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		$outbound_bot = OutboundBot::findOrFail($id);

		$outbound_bot->name = $request->input("name");
        $outbound_bot->description = $request->input("description");
        $outbound_bot->phone_number = $request->input("phone_number");
        $outbound_bot->customer_list_id = $request->input("customer_list_id");

		$outbound_bot->save();

		return redirect()->route('outbound_bots.index')->with('message', 'Item updated successfully.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$outbound_bot = OutboundBot::findOrFail($id);
		$outbound_bot->delete();

		return redirect()->route('outbound_bots.index')->with('message', 'Item deleted successfully.');
	}

	public function run($id)
    {
        $bot = OutboundBot::find($id);
        $question = Question::where('bot_id', $id)->first();
        $customers = CustomerList::all();

        $twillioClient = new Client(env('TWILLIO_SID'), env('TWILLIO_TOKEN'));

        foreach ($customers as $customer) {
            $existingConversation = Conversation::where([
                ['bot_id', '=', $id,],
                ['customer_phone_number', '=', $customer->phone_number],
                ['status', '!=', 'ENDED']
            ])->first();

            if($existingConversation){
                return JsonResponse::create("
                    A conversation for customer $customer->full_name with bot id $id is already in progress"
                );
            }

            Conversation::create([
                'bot_id' => $id,
                'customer_phone_number' => $customer->phone_number,
                'status' => 'STARTED',
                'last_question_id' => $question->id
            ]);

            $response = $twillioClient->messages->create(
                "+$customer->phone_number",
                [
                    'from' => "+$bot->phone_number",
                    'body' => $this->parseQuestion($customer->full_name, $question->question)
                ]
            );



            Log::info($response);
        }

        $people = implode(', ',CustomerList::all()->pluck('full_name')->toArray());
        return JsonResponse::create("The customers [$people] were sent the message:  $question->question");
    }

    public function reply(Request $request)
    {
        $twiml = new Twiml();
        $twiml->header('Content-Type', 'text/xml');
        $customerPhoneNumber = str_replace('+', '', $request->input('From'));
        $botPhoneNumber = str_replace('+', '', $request->input('To'));
        $bot = OutboundBot::where('phone_number', $botPhoneNumber)->first();
        $conversation = Conversation::where([
            ['customer_phone_number', '=', $customerPhoneNumber],
            ['bot_id', '=', $bot->id],
            ['status', '!=', 'ENDED']
        ])->first();
        $question = Question::find($conversation->last_question_id);

        $answer = $this->getAnswer($request, $question);

        if (!$answer) {
            $validAnswers = Answer::where('question_id', $question->id)->pluck('trigger');
            $twiml->sms($question->question . "\n\nPlease answer with one of the following.\n" . $validAnswers);
        } elseif ($answer->next_question_id) {
            $conversation->status = 'IN_PROGRESS';
            $nextQuestion = Question::find($answer->next_question_id);
            $conversation->last_question_id = $answer->next_question_id;
            $twiml->sms($answer->answer . "\n\n" . $nextQuestion->question);
        } else {
            $twiml->sms($answer->answer);
            $conversation->status = 'ENDED';
        }

        $conversation->save();

        $twiml = Response::make($twiml, 200);

        return $twiml;
    }

    /**
     * @param $customer
     * @param $question
     * @return mixed
     */
    private function parseQuestion($customer, $question)
    {
        return str_replace('{{full_name}}', $customer, $question);
    }

    /**
     * @param Request $request
     * @param $question
     * @return mixed
     */
    private function getAnswer(Request $request, $question)
    {
        $answer = Answer::where([
            'question_id' => $question->id,
            'trigger'     => $request->input('Body')
        ])->first();

        return $answer;
    }
}
