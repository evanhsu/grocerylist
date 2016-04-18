<?php

namespace GroceryListApi;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 **/
class Item extends Model
{
	public function __construct()
	{
	}

	public function groceryList()
	{
		return $this->belongsTo('GroceryListApi\GroceryList');
	}

	public function isComplete() {
		// Return a boolean that describes whether this grocery item has been marked as 'complete' or not.
		return $this->complete;
	}

	public function toggleComplete()
	{
		# Toggle the boolean attribute "complete"
		$this->complete = $this->complete ? false : true;
		return $this->complete; // Return the new value of 'complete'
	}

	

}
