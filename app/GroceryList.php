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

	public static function boot()
    {
        parent::boot();

        // When a GroceryList is deleted, also delete all Items that were on that list.
        static::deleted(function ($groceryList) {
            foreach($groceryList->items as $item) {
                $item->delete();
            }
        });
    }

	public function items()
	{
		return $this->hasMany('GroceryListApi\Item');
	}

	public function users()
	{
		// One or more Users can be connected to a Grocery List through the 'grocery_list_user' pivot table.
		return $this->belongsToMany('GroceryListApi\User')->withPivot('nickname');
	}
}
