<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;

class OrderController extends Controller
{
    public function getOrders($id){
        
        return Order::where(['orders.user_id' => $id, 'orders.status' => 'received'])
                    ->with(['order_details' => function ($query){
                        $query->join('products','order_details.product_id','=','products.id');
                    }])
                    ->get();
    }
    public function createOrder(Request $request){

       $items = $request->items;
       $total_price = $request->total_price;
       $user_desc = $request->user_desc;
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
        /////////////////update data//////////// ///5,4,003004,1000,889
        try {
            $user->update($user_data);

            try {
                $order = Order::create([
                    'total' => $total_price,
                    'user_id' => $user_id,
                    'user_desc' => $user_desc,
                    
                ]);
                $order_id = $order->id;

                for ($i=0; $i < count($items)  ; $i++) { 
                    $item_data[] = ['quantity' => $items[$i]['quantity'], 'now_price' => $items[$i]['price'], 'order_id' => $order_id, 'product_id' => $items[$i]['id']];
                }

                try {
                    OrderDetail::insert($item_data);
                    /*send sms */
                    try {
                        
                            $to = '+255686255811';
                            $from = getenv("TWILIO_FROM");
                            $message = 'leoleomarket new order from '.$request->user['fullname'];
                            //open connection

                            $ch = curl_init();

                            //set the url, number of POST vars, POST data
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_USERPWD, getenv("TWILIO_SID").':'.getenv("TWILIO_TOKEN"));
                            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
                            curl_setopt($ch, CURLOPT_URL, sprintf('https://api.twilio.com/2010-04-01/Accounts/'.getenv("TWILIO_SID").'/Messages.json', getenv("TWILIO_SID")));
                            curl_setopt($ch, CURLOPT_POST, 3);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, 'To='.$to.'&From='.$from.'&Body='.$message);

                            // execute post
                            $result = curl_exec($ch);
                            $result = json_decode($result);

                            // close connection
                            curl_close($ch);
                            //Sending message ends here

                    } catch (\Throwable $th) {
                        return 'created';
                    }

                    /**end send sms */

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
