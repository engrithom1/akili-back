<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
   public function index(){
        return Category::select()
                        ->with('products')
                        ->get();
   }

   public function topCategories(){
        return Category::select()
                       ->with('products')
                       ->limit(3)
                       ->get();
    }

    public function getCategory($id){
        return Category::where('id',$id)
                       ->first();
    }

    public function productsByCategory($id){

        $products = Product::where(['products.category_id' => $id, 'products.status' => 1])
        ->orderBy('products.views','desc')
        ->join('discounts','products.discount_id', '=', 'discounts.id')
        ->select('products.name','products.desc','products.slug','products.price','products.thumb','products.id','discounts.percent')
        ->limit(8)
        ->get();

        $recommended = Product::where(['products.category_id' => $id, 'products.status' => 1])
        ->orderBy('products.views','asc')
        ->join('discounts','products.discount_id', '=', 'discounts.id')
        ->select('products.name','products.desc','products.slug','products.price','products.thumb','products.id','discounts.percent')
        ->limit(18)
        ->get();

        $dataz = [
            $products,$recommended
         ];

        return $dataz;
    }

}

