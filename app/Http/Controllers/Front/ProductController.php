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
        
        $prodz = Product::all();
        $products = ProductResource::collection($prodz);

        return $products;
    }
}
