<?php

namespace App\Http\Controllers;

use App\Checkout;
use App\InventoryProjectItem;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;


class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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

      $checkout = new Checkout;
      $checkout->customer_id = $request->input('customer_id');
      $checkout->item_id	= $request->input('item_id');
      $checkout->invoice_id	=$request->input('invoice_id');
      $checkout->notes=$request->input('notes');
      if($file = $request->hasFile('check_out_image')) {

            $file = $request->file('check_out_image') ;
            $fileName = $file->getClientOriginalName() ;
            $destinationPath = base_path().'/storage/uploads' ;
            $file->move($destinationPath,$fileName);
            $checkout->check_out_image = $fileName ;
        }

        if($file = $request->hasFile('check_out_signature')) {

          $file = $request->file('check_out_signature') ;
          $fileName = $file->getClientOriginalName() ;
          $destinationPath = base_path().'/storage/uploads' ;
          $file->move($destinationPath,$fileName);
          $checkout->check_out_signature = $fileName ;
      }
      $checkout->save();
      if ($checkout->save())

      {
          if($request->input('item_id')!=null||!empty($request->input('item_id')))
          {

              $projectitem = new InventoryProjectItem;
              $projectitem->item_id = $request->input('item_id');
              $projectitem = InventoryProjectItem::find($projectitem->item_id);
              $projectitem->delete();

          }

      }
      return redirect()->back()->with('message','Check out Successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function show(checkout $checkout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function edit(checkout $checkout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, checkout $checkout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function destroy(checkout $checkout)
    {
        //
    }
}
