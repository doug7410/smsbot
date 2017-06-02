<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CustomerList;
use Illuminate\Http\Request;

class CustomerListController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$customer_lists = CustomerList::orderBy('id', 'desc')->paginate(10);

		return view('customer_lists.index', compact('customer_lists'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('customer_lists.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$customer_list = new CustomerList();

		$customer_list->full_name = $request->input("full_name");
        $customer_list->phone_number = $request->input("phone_number");

		$customer_list->save();

		return redirect()->route('customer_lists.index')->with('message', 'Item created successfully.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$customer_list = CustomerList::findOrFail($id);

		return view('customer_lists.show', compact('customer_list'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$customer_list = CustomerList::findOrFail($id);

		return view('customer_lists.edit', compact('customer_list'));
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
		$customer_list = CustomerList::findOrFail($id);

		$customer_list->full_name = $request->input("full_name");
        $customer_list->phone_number = $request->input("phone_number");

		$customer_list->save();

		return redirect()->route('customer_lists.index')->with('message', 'Item updated successfully.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$customer_list = CustomerList::findOrFail($id);
		$customer_list->delete();

		return redirect()->route('customer_lists.index')->with('message', 'Item deleted successfully.');
	}

}
