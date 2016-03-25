<?php

namespace GroceryListApi\Http\Controllers;

use Illuminate\Http\Request;
use GroceryListApi\Http\Requests;
use GroceryListApi\Models;

class ListController extends Controller
{
    /**
     * Display a listing of all Lists.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return(List::all()); // Return a serialized JSON string
    }

    /**
     * Accepts a JSON string with parameters for a new List (List Nickname, User, etc) and
     * creates a new List in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
}
