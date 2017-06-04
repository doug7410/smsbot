<?php namespace App\Http\Controllers;

use App\Answer;
use App\Conversation;
use App\CustomerList;
use App\OutboundBot;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class AnswerController extends Controller {

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($botID, $questionID)
	{
        $bot = OutboundBot::findOrFail($botID);
        $question = Question::findOrFail($questionID);
        $relatedQuestions = Question::where([
            ['bot_id', '=', $botID],
            ['id', '!=', $questionID]
        ])->get()->push((object) ['id' => null, 'question' => 'none']);
		return view('answers.create', compact('bot', 'question', 'relatedQuestions'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$answer = Answer::create([
		    'bot_id'            => $request->input("bot_id"),
            'question_id'       => $request->input("question_id"),
            'trigger'           => $request->input("trigger"),
            'answer'            => $request->input("answer"),
            'next_question_id'  => $request->input("next_question_id") ?: null
        ]);

		if($request->input('new_question')) {
		    $question = Question::create([
		        'question' => $request->input('new_question'),
                'bot_id' => $request->input('bot_id')
            ]);
		    $answer->next_question_id = $question->id;
		    $answer->save();
        }
		return redirect()->route('outbound_bots.show', $answer->bot_id);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$answer = Answer::findOrFail($id);
        $bot = OutboundBot::findOrFail($answer->bot_id);
        $question = Question::findOrFail($answer->question_id);
        $relatedQuestions = Question::where([
            ['bot_id', '=', $answer->bot_id],
            ['id', '!=', $answer->question_id]
        ])->get()->push((object) ['id' => null, 'question' => 'none']);


		return view('answers.edit', compact('answer', 'bot', 'question', 'relatedQuestions'));
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
		$answer = Answer::findOrFail($id);

		$answer->bot_id = $request->input("bot_id");
        $answer->question_id = $request->input("question_id");
        $answer->trigger = $request->input("trigger");
        $answer->answer = $request->input("answer");
        $answer->next_question_id = $request->input("next_question_id") ?: null;

		$answer->save();

		return redirect()->route('outbound_bots.show', $answer->bot_id)->with('message', 'Item updated successfully.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$answer = Answer::findOrFail($id);
		$answer->delete();

		return redirect()->route('answers.index')->with('message', 'Item deleted successfully.');
	}

}
