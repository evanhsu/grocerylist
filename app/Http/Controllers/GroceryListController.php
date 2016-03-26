<?php

namespace GroceryListApi\Http\Controllers;

use Illuminate\Http\Request;
use GroceryListApi;
use GroceryListApi\Http\Requests;

use Auth; 

class GroceryListController extends Controller
{
    /**
     * Display a listing of all Lists.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $lists = GroceryListApi\GroceryList::all(); // Return a collection
        // return $lists;
        return Auth::user();
    }

    /**
     * Accepts a POST request with parameters for a new List (List Nickname, User, etc) and
     * creates a new List in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate
        $data = $request->all();
        $validator = $this->listValidator($data);

        if($validator->fails()) {
            return response()->json(['success' => false, 'id' => ''], 422); // 422: Unprocessable entity
        }

        // Create new List
        $list = new GroceryList();
        $list->save();

        // Bind new List to the User who created it
        //$list->


        return response()->json(['success' => $success, 'id' => $listId], $HttpStatus);
    }

    /**
     * Display the specified List
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Associate a specific grocery List with a specific User.
     * This List will then be visible in the User's index of lists.
     *
     * @return void
     **/
    public function bindUser($id)
    {
        // 
    }

}
