<?php

namespace GroceryListApi\Http\Controllers;

use Illuminate\Http\Request;
use GroceryListApi\Http\Requests;
use GroceryListApi;

class UserController extends Controller
{
    public function grocerylists($id)
    {
    	// Display an index of all the GroceryLists associated with the requested User
    	$grocery_lists = GroceryListApi\User::find($id)->grocerylists;

    	// TODO: format/paginate this list
    	$HttpStatus = 200; // OK
    	return response()->json(['data' => $grocery_lists], $HttpStatus);
    }
}
