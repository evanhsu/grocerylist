<?php

namespace GroceryListApi;

use Illuminate\Database\Eloquent\Model;

/**
 * undocumented class
 *
 **/
class Item extends Model
{
	public function __construct()
	{
	}

	public function groceryList()
	{
		return $this->belongs_to('GroceryListApi\GroceryList');
	}

}
