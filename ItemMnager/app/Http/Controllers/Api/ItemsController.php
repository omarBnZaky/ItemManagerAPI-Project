<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Item;
use Illuminate\Http\Request;

use Validator;
class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = Item::latest()->paginate(25);

        return $items;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[ 
            'text'=>'required' 
        ]);
        if($validator->fails()){
            $response = array('response'=>$validator->messages(),'success' => false);
            return $response;
        }else{
            
            $item = Item::create($request->all());

            return response()->json($item, 201);
    
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::findOrFail($id);

        return $item;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $validator = Validator::make($request->all(),[ 
            'text'=>'required' 
        ]);
        if($validator->fails()){
            $response = array('response'=>$validator->messages(),'success' => false);
            return $response;
        }else{
            $item->update($request->all());

            return response()->json($item, 200);
        }
  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Item::destroy($id);
        $response = array('response'=>'Item deleted','success' => true);

        return  $response;
      //  return response()->json(null, 204);
    }
}
