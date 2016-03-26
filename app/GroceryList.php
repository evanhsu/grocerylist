<?php

namespace GroceryListApi;

use Illuminate\Database\Eloquent\Model;

/**
 * class List
 * 
 * This is a GroceryList which contains ListItems and
 * can belong to one or more Users.
 *
 **/

class GroceryList extends Model
{
	public function __construct()
	{
	}

	public function Items()
	{
		$this->hasMany('GroceryListApi\Item');
	}

	public function Users()
	{
		// One or more Users can be connected to a Grocery List through the 'list_user' pivot table.
		$this->belongsToMany('GroceryListApi\User');
	}
}
