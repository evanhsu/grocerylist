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
    	if(app()->environment('local')) {
		    // Log in a test user during development - this user is always logged in...
		    if(!Auth::check()) {
			    $loggedInUser = GroceryListApi\User::first();
			    Auth::login($loggedInUser);
			}
		}
    }
    
}
