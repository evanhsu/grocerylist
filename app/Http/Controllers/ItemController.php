<?php

namespace GroceryListApi\Http\Controllers;

use Illuminate\Http\Request;
use GroceryListApi\Http\Requests;
use GroceryListApi;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Unused
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->all();
        /*
        $validator = $this->itemValidator($data);

        if($validator->fails()) {
            return response()->json(['success' => false, 'id' => ''], 422); // 422: Unprocessable entity
        }
        */
        $groceryList = GroceryListApi\GroceryList::find($request->groceryListId);
        $item = new GroceryListApi\Item;

        $item->complete = false; // All new items are created as 'incomplete'
        $item->position = $groceryList->newItemPosition();
        $item->name = $request->name;
        $groceryList->items()->save($item); // Save this item and associate it with a grocery list.

        $success = true;
        $itemId = $item->id;
        $HttpStatus = 200;

        return response()->json(['success' => $success, 'id' => $itemId], $HttpStatus);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Unused
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Unused
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

    }

    public function toggleComplete($id)
    {
        # Toggle the value of the boolean attribute 'complete'
        try {
            $item = GroceryListApi\Item::find($id);
            $item->toggleComplete();
            $item->save();

            $success = true;
            $HttpStatus = 200; // OK

        } catch (Exception $e) {
            $success = false;
            $HttpStatus = 500; // Internal Server Error - used for a generic failure with no additional details.
        }

        return response()->json(['success' => $success, 'id' => $id], $HttpStatus); 
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $item = GroceryListApi\Item::find($id);
        $item->delete();

        $success = true;
        $HttpStatus = 200;

        return response()->json(['success' => $success, 'id' => $id], $HttpStatus); 
    }
}
