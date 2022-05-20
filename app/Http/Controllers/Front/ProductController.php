<?php

namespace App\Http\Controllers\Front;

use App\Http\Resources\ProductResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Tags;

class ProductController extends Controller
{
   

    
    public function index()
    {
        $products = Product::orderBy('products.views','desc')
        ->where('products.status', 1)
        ->join('discounts','products.discount_id', '=', 'discounts.id')
        ->select('products.name','products.desc','products.slug','products.price','products.thumb','products.id','discounts.percent')
        ->limit(12)
        ->get();

        $recommended = Product::orderBy('products.views','asc')
        ->where('products.status', 1)
        ->join('discounts','products.discount_id', '=', 'discounts.id')
        ->select('products.name','products.desc','products.slug','products.price','products.thumb','products.id','discounts.percent')
        ->limit(12)
        ->get();

        $offers = Product::orderBy('products.views','desc')
        ->join('discounts','products.discount_id', '=', 'discounts.id')
        ->select('products.name','products.desc','products.slug','products.price','products.thumb','products.id','discounts.percent')
        ->where([['discounts.percent','>=', 1],'products.status' => 1])
        ->limit(8)
        ->get();

        //$prodz = Product::all();
        //$products = ProductResource::collection($prodz);
        $dataz = [
           $products,$offers,$recommended
        ];

        return $dataz;
    }

    public function show($id)
    {
        $product = Product::join('categories','products.category_id','=','categories.id')
                            ->join('discounts','products.discount_id', '=', 'discounts.id')
                            ->select('products.name','products.desc','products.price','products.thumb','products.id','products.tag','products.views','discounts.percent')
                            ->where(['products.id' => $id])->first();
        return $product;
    }

    public function related($id){
        $product = Product::where(['id' => $id])->first();
        $category_id = $product['category_id'];

        $products = Product::orderBy('products.views','desc')
        ->join('discounts','products.discount_id', '=', 'discounts.id')
        ->select('products.name','products.desc','products.slug','products.price','products.thumb','products.id','discounts.percent')
        ->where(['products.category_id' => $category_id,'products.status' => 1])
        ->limit(8)
        ->get();

        return $products;
    }

    public function addViews($id){
        $product = Product::where(['id' => $id])->first();
        $views = $product['views'];
        
        $views += 1;

        try {
            $product->update(['views' => $views]);

            return ['views' => $views];
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
