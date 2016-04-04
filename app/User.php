<?php

namespace GroceryListApi;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function groceryLists()
    {
        // A User can be connected to a one or more grocery Lists through the 'list_user' pivot table.
        $this->belongsToMany('GroceryListApi\GroceryList');
    }
}
