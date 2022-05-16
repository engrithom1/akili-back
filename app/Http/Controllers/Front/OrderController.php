<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;

class OrderController extends Controller
{
    public function createOrder(Request $request){

       $items = $request->items;
       $total_price = $request->total_price;
       $item_data = array();

     

        ////////////user update/////////////////
        $user_id = $request->user['id'];
        $user = User::findOrfail($user_id);

        $user_data = [
            'fullname' => $request->user['fullname'],
            'region' => $request->user['region'],
            'address' => $request->user['address'],
            'phonenumber' => $request->user['phonenumber'],
            
        ];
        /////////////////update data////////////
        try {
            $user->update($user_data);

            try {
                $order = Order::create([
                    'total' => $total_price,
                    'user_id' => $user_id
                    
                ]);
                $order_id = $order->id;

                for ($i=0; $i < count($items)  ; $i++) { 
                    $item_data[] = ['quantity' => $items[$i]['quantity'], 'now_price' => $items[$i]['price'], 'order_id' => $order_id, 'product_id' => $items[$i]['id']];
                }

                try {
                    OrderDetail::insert($item_data);

                    return 'created';

                } catch (\Throwable $th) {
                    return 'error on create order details'.$th;
                }


            } catch (\Throwable $th) {
                return 'error on create order'.$th;
            }

        } catch (\Throwable $th) {
            return 'error on update user'.$th;

        }


    }
}
