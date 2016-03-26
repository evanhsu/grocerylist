<?php

namespace GroceryListApi\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Auth;
use GroceryListApi;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
	    // Log in a test user during development - this user is always logged in...
	    $loggedInUser = GroceryListApi\User::where("email", "testdummy@testing.com")->first();
	    Auth::login($loggedInUser);
    }
    
}
