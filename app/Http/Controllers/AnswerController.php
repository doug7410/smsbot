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
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$answers = Answer::orderBy('id', 'desc')->paginate(10);

		return view('answers.index', compact('answers'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('answers.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$answer = new Answer();
		$answer->bot_id = $request->input("bot_id");
        $answer->question_id = $request->input("question_id");
        $answer->trigger = $request->input("trigger");
        $answer->answer = $request->input("answer");
        $answer->next_question_id = $request->input("next_question_id") ?: null;

		$answer->save();

		return redirect()->route('outbound_bots.show', $answer->bot_id)->with('message', 'Item created successfully.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$answer = Answer::findOrFail($id);

		return view('answers.show', compact('answer'));
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

		return view('answers.edit', compact('answer'));
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
