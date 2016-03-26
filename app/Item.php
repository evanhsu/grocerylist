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

	public function List()
	{
		$this->belongs_to('GroceryListApi\GroceryList');
	}

}
