<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Conversation;
use Illuminate\Http\Request;

class ConversationController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$conversations = Conversation::orderBy('id', 'desc')->paginate(10);

		return view('conversations.index', compact('conversations'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('conversations.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$conversation = new Conversation();

		$conversation->bot_id = $request->input("bot_id");
        $conversation->customer_phone_number = $request->input("customer_phone_number");
        $conversation->status = $request->input("status");
        $conversation->last_question_id = $request->input("last_question_id");

		$conversation->save();

		return redirect()->route('conversations.index')->with('message', 'Item created successfully.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$conversation = Conversation::findOrFail($id);

		return view('conversations.show', compact('conversation'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$conversation = Conversation::findOrFail($id);

		return view('conversations.edit', compact('conversation'));
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
		$conversation = Conversation::findOrFail($id);

		$conversation->bot_id = $request->input("bot_id");
        $conversation->customer_phone_number = $request->input("customer_phone_number");
        $conversation->status = $request->input("status");
        $conversation->last_question_id = $request->input("last_question_id");

		$conversation->save();

		return redirect()->route('conversations.index')->with('message', 'Item updated successfully.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$conversation = Conversation::findOrFail($id);
		$conversation->delete();

		return redirect()->route('conversations.index')->with('message', 'Item deleted successfully.');
	}

}
