<?php

namespace GroceryListApi\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * class List
 * 
 * This is a grocery list which contains ListItems and
 * can belong to one or more Users.
 *
 **/

class List extends Model
{
	public function __construct()
	{
	}

	public function Items()
	{
		$this->hasMany('GroceryListApi\Models\Item');
	}

	public function Users()
	{
		// One or more Users can be connected to a Grocery List through the 'list_user' pivot table.
		$this->belongsToMany('GroceryListApi\Models\User');
	}
}
