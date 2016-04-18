<?php

namespace GroceryListApi\Http\Controllers;

use Illuminate\Http\Request;
use GroceryListApi;
use GroceryListApi\Http\Requests;

use Auth; 

class GroceryListController extends Controller
{

    /**
     * Require an authenticated user for all controller methods.
     *
     **/
    function __construct()
    {
        parent::__construct(); // This logs in a user to allow testing without interference from authentication
        $this->middleware('auth');
    }


    /**
     * Display an index of all GroceryLists. This should be an admin function.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lists = GroceryListApi\GroceryList::all(); // TODO: format & paginate this result set.
        return $lists;
    }

    /**
     * Accepts a POST request with parameters for a new List (List Nickname, User, etc) and
     * creates a new List in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate
        $data = $request->all();
        /*
        $validator = $this->groceryListValidator($data);

        if($validator->fails()) {
            return response()->json(['success' => false, id' => ''], 422); // 422: Unprocessable entity
        }
        */
        // Create new List
        $list = new GroceryListApi\GroceryList();
        $list->save();

        // Bind this new GroceryList to the User who created it (the current User)
        $list->Users()->attach(Auth::user()->id, ['nickname'=>$request->get('nickname')]);
        $listId = $list->id;
        $success = true;
        $HttpStatus = 200;

        return response()->json(['success' => $success, 'id' => $listId], $HttpStatus);
    }

    /**
     * Return the specified List with all of its items
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Retrieve the properties of this list and all of its list items.
        $list = GroceryListApi\User::find(Auth::user()->id)->with(['grocerylists' => function ($query) use ($id) {
            $query->where('grocery_lists.id','=',$id);
        },'grocerylists.items'])->get();

        return $list;
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
        // Validate
        $data = $request->all();
        /*
        $validator = $this->groceryListValidator($data);

        if($validator->fails()) {
            return response()->json(['success' => false, 'id' => ''], 422); // 422: Unprocessable entity
        }
        */
        // Update the List
        $list = GroceryListApi\GroceryList::find($id);
        // Change something...
        $list->user()->updateExistingPivot($userId, array('nickname'=>$data.nickname));
        $list->save(); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $list = GroceryListApi\GroceryList::find($id);
        $list->delete(); // The GroceryList model has a "deleted" event listener that destroys related models (Items).

        return response()->json(['success' => true, 'id' => $id], 200);
    }

    /**
     * Associate a specific grocery List with a specific User.
     * This List will then be visible in the User's index of lists.
     *
     * @return void
     **/
    public function bindUser($id)
    {
        // 
    }

}
