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
        // Unused
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
        $groceryList = GroceryListApi\GroceryList::find($request->$grocery_list_id);
        $item = new GroceryListApi\Item;

        $item->complete = false; // All new items are created as 'incomplete'
        $item->position = $groceryList->newItemPosition();
        $item->name = $request->name;
        $groceryList->items()->save($item); // Save this item and associate it with a grocery list.

        $success = true;
        $item_id = $item->id;
        $HttpStatus = 200;

        return response()->json(['success' => $success, 'id' => $item_id], $HttpStatus);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $item = GroceryListApi\Item::find($id);
        return response()->json($item);
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
        $data = $request->all(); 
       /*
        $validator = $this->itemValidator($data);

        if($validator->fails()) {
            return response()->json(['success' => false, 'id' => ''], 422); // 422: Unprocessable entity
        }
        */ 
        try {
            $item = GroceryListApi\Item::find($id);
            if(is_null($item)) throw new \Exception('Item not found',404);

            // Set the new item properties
            if (!empty($request->input('complete'))) {
                $item->complete = $request->input('complete');
            }
            if (!empty($request->input('name'))) {
                $item->name = $request->input('name');
            }
            // position CANNOT be updated through this method. Use the updatePosition() method instead;

            // Save the item and prepare the response
            $item->save();
            $success = true;
            $HttpStatus = 200;

        } catch(\Exception $e) {
            $success = false;
            $error_code = $e->getCode();
            $HttpStatus = $error_code ? $error_code : 500;
        }

        return response()->json(['success' => $success, 'id' => $id], $HttpStatus);
    }

    public function updatePosition(Request $request, $id)
    {
        // Change the position of the requested Item to the new position, and then shuffle the other items in this GroceryList accordingly
        $item = GroceryListApi\Item::find($id);
        $grocery_list_id = $item->groceryList->id;
        $new_position = $request->input('position');
        $old_position = $item->position;

        $item->position = $new_position;
        if($old_position > $new_position) {
            // This item moves UP (bigger numbers are lower on the list), move the items around it DOWN
            $this->moveDownOnePosition($id,$grocery_list_id,$old_position,$new_position);
        }
        elseif($old_position < $new_position) {
            // This item moves down, but the items around it must move UP
            $this->moveUpOnePosition($id,$grocery_list_id,$old_position,$new_position);
        }
        $item->save();

        $success = true;
        $HttpStatus = 200;

        return response()->json(['success' => $success, 'id' => $id], $HttpStatus);
    }

    public function toggleComplete($id)
    {
        # Toggle the value of the boolean attribute 'complete'
        try {
            $item = GroceryListApi\Item::find($id);
            if(is_null($item)) throw new \Exception('Item not found',404);

            $item->toggleComplete();
            $item->save();

            $success = true;
            $HttpStatus = 200; // OK

        } catch (\Exception $e) {
            $success = false;
            $error_code = $e->getCode();
            $HttpStatus = $error_code ? $error_code : 500; // Default is Internal Server Error if no code is provided 
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

    private function moveUpOnePosition($item_id,$grocery_list_id,$first_pos,$last_pos) 
    {
        // Change the position of each item between $first_pos and $last_pos (inclusive) by -1 (move UP)
        try {
            \DB::table('items')
                ->whereBetween('position',[$first_pos,$last_pos])
                ->where('id','<>',$item_id)
                ->where('grocery_list_id','=',$grocery_list_id)
                ->decrement('position');

        } catch(\Exception $e) {
            throw $e;

            return false;
        }
        return true;
    }

    private function moveDownOnePosition($item_id,$grocery_list_id,$first_pos,$last_pos)
    {
        // Change the position of each item between $first_pos and $last_pos (inclusive) by +1 (move DOWN) 
        try {
             \DB::table('items')
                ->whereBetween('position',[$last_pos,$first_pos])
                ->where('id','<>',$item_id)
                ->where('grocery_list_id','=',$grocery_list_id)
                ->increment('position');

        } catch(\Exception $e) {
            throw $e;
            return false;
        }
        return true;
    }

}
