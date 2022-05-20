<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('orders.id','desc')
        ->join('users','orders.user_id', '=', 'users.id')
        ->select('orders.total','orders.id','orders.status','users.fullname','users.phonenumber')
        ->where('orders.status','received')
        ->get();


        
        return view('order.index',compact('orders'));
    }

    public function doneOrder()
    {
        $orders = Order::orderBy('orders.id','desc')
        ->join('users','orders.user_id', '=', 'users.id')
        ->select('orders.total','orders.id','orders.status','users.fullname','users.phonenumber')
        ->where('orders.status','done')
        ->get();


        
        return view('order.done',compact('orders'));
    }

    public function rejectedOrder()
    {
        $orders = Order::orderBy('orders.id','desc')
        ->join('users','orders.user_id', '=', 'users.id')
        ->select('orders.total','orders.id','orders.status','users.fullname','users.phonenumber')
        ->where('orders.status','rejected')
        ->get();


        
        return view('order.rejected',compact('orders'));
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //return 'show order';
        $oda = Order::where(['id' => $id])->first();
        

        $orders = OrderDetail::where('order_details.order_id',$id)
        ->join('products','order_details.product_id', '=', 'products.id')
        ->select('order_details.now_price','order_details.order_id','order_details.quantity','products.name','products.thumb','products.price')
        ->get();


        
        return view('order.show',compact('orders','oda'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
            $id = $order->id;

            $request->validate([
                'status' => 'required',
                'admin_desc' => 'required',
            ]);


            $data = [
                'status' => $request->input('status'),
                'admin_desc' => $request->input('admin_desc'),
                'user_id' => Auth::user()->id,
            ];

        try {

            $order->update(
                $data
            );

            return redirect()->route('order.index')->with('message', 'Order Updated Successfull');
        } catch (\Exception $th) {

            $oda = Order::where(['id' => $id])->first();
        
            $orders = OrderDetail::where('order_details.order_id',$id)
            ->join('products','order_details.product_id', '=', 'products.id')
            ->select('order_details.now_price','order_details.order_id','order_details.quantity','products.name','products.thumb','products.price')
            ->get();

            return redirect()->route('order.show', $order->id,compact('orders','oda'))->with('message', 'Problem with Database.');
        }
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
    }
}
