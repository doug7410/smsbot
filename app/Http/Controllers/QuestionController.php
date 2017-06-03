<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\OutboundBot;
use App\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$questions = Question::orderBy('id', 'desc')->paginate(10);

		return view('questions.index', compact('questions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($botId)
	{
	    $bot = OutboundBot::findOrFail($botId);
		return view('questions.create', ['bot' => $bot]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$question = new Question();

		$question->bot_id = $request->input("bot_id");
        $question->question = $request->input("question");

		$question->save();

		return redirect()->route('outbound_bots.show', $question->bot_id)->with('message', 'Item created successfully.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$question = Question::findOrFail($id);

		return view('questions.show', compact('question'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$question = Question::findOrFail($id);

		return view('questions.edit', compact('question'));
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
		$question = Question::findOrFail($id);

		$question->bot_id = $request->input("bot_id");
        $question->question = $request->input("question");

		$question->save();

		return redirect()->route('outbound_bots.show', $question->bot_id)->with('message', 'Item updated successfully.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$question = Question::findOrFail($id);
		$question->delete();

		return redirect()->route('questions.index')->with('message', 'Item deleted successfully.');
	}

}
