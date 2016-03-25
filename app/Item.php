<?php

namespace GroceryListApi\Models;

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
		$this->belongs_to('GroceryListApi\Models\List');
	}

}
