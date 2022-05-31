<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tags;

class TagController extends Controller
{
   public function index(){
        return Tags::select()
                        ->get();
   }

   public function topTags(){
        return Tags::select()
                       ->limit(5)
                       ->get();
    }

    public function getTag($id){
        return Tags::where('id',$id)
                       ->first();
    }

    public function productsByTag($id){

        //$value = Tags::select('id')->get();
        $value = [4,5,6,7,8,9];
    
        //$f = explode(",", $value);

        $products = Product::where('products.status', 1)
        //->whereIn('products.tag',$value)
        ->orderBy('products.views','desc')
        ->join('discounts','products.discount_id', '=', 'discounts.id')
        ->select('products.name','products.desc','products.slug','products.price','products.thumb','products.id','discounts.percent')
        ->limit(8)
        ->get();

        $recommended = Product::where('products.status', 1)
        //->whereIn('products.tag',$id)
        ->orderBy('products.views','asc')
        ->join('discounts','products.discount_id', '=', 'discounts.id')
        ->select('products.name','products.desc','products.slug','products.price','products.thumb','products.id','discounts.percent')
        ->get();

        $dataz = [
            $products,$recommended
         ];

        return $dataz;
    }

}

