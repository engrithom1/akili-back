<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\ProductResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illumonate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Tags;

class ProductController extends Controller
{
    //function sanitize_title_with_dashes taken from wordpress
    public static function sanitize($title) {
        $title = strip_tags($title);
        // Preserve escaped octets.
        $title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
        // Remove percent signs that are not part of an octet.
        $title = str_replace('%', '', $title);
        // Restore octets.
        $title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);
    
        $title = strtolower($title);
        $title = preg_replace('/&.+?;/', '', $title); // kill entities
        $title = str_replace('.', '-', $title);
        $title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
        $title = preg_replace('/\s+/', '-', $title);
        $title = preg_replace('|-+|', '-', $title);
        $title = trim($title, '-');
    
        return $title;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodz = Product::where('status','1')->get();
        $products = ProductResource::collection($prodz);

        
        return view('product.index',compact('products'));
    }

    public function inActive()
    {
        $prodz = Product::where('status','0')->get();
        $products = ProductResource::collection($prodz);

        
        return view('product.inactive',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tags::all();
        $discounts = Discount::all();

        return view('product.create',compact('categories','tags','discounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $request->validate([
            'name' => 'required',
            'desc' => 'required',
            'thumb' => 'required|mimes:jpg,png,jpeg|max:500',
            'category' => 'required',
            'discount' => 'required',
            'price' => 'required',
            'tags' => 'required'
        ]);

        $thumb = preg_replace('/\s+/', '', $request->thumb->getClientOriginalName());

        $thumb = time().'-'.$thumb;

        $request->thumb->move(public_path('images'), $thumb);

        $slug = ProductController::sanitize($request->input('name'));

        $product = Product::create([
            'name' => $request->input('name'),
            'desc' => $request->input('desc'),
            'price' => $request->input('price'),
            'tag' => $request->input('tags'),
            'category_id' => $request->input('category'),
            'discount_id' => $request->input('discount'),
            'user_id' => Auth::user()->id,
            'thumb' => $thumb,
            'slug' => $slug
        ]);

        return redirect()->route('product.index')->with('message','Product Created Successfull');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $tags = Tags::all();
        $discounts = Discount::all();

        return view('product.edit',compact('product','categories','tags','discounts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if(count($request->all()) == 10){
           
            $request->validate([
                'name' => 'required',
                'status' => 'required',
                'desc' => 'required',
                'thumb' => 'required|mimes:jpg,png,jpeg|max:500',
                'category' => 'required',
                'discount' => 'required',
                'price' => 'required',
                'tags' => 'required'
            ]);

            $thumb = preg_replace('/\s+/', '', $request->thumb->getClientOriginalName());

            $thumb = time().'-'.$thumb;
    
            $request->thumb->move(public_path('images'), $thumb);
//delete existing image
            unlink("images/".$product->thumb);

            $slug = ProductController::sanitize($request->input('name'));

            $data = [
                'name' => $request->input('name'),
                'desc' => $request->input('desc'),
                'price' => $request->input('price'),
                'tag' => $request->input('tags'),
                'category_id' => $request->input('category'),
                'status' => $request->input('status'),
                'discount_id' => $request->input('discount'),
                'user_id' => Auth::user()->id,
                'thumb' => $thumb,
                'slug' => $slug
            ];

        }else{
           
            $request->validate([
                'name' => 'required',
                'desc' => 'required',
                'status' => 'required',
                'category' => 'required',
                'discount' => 'required',
                'price' => 'required',
                'tags' => 'required'
            ]);

            $slug = ProductController::sanitize($request->input('name'));

            //return $slug;

            $data = [
                'name' => $request->input('name'),
                'desc' => $request->input('desc'),
                'price' => $request->input('price'),
                'tag' => $request->input('tags'),
                'category_id' => $request->input('category'),
                'status' => $request->input('status'),
                'discount_id' => $request->input('discount'),
                'user_id' => Auth::user()->id,
                'slug' => $slug
                
            ];
        }

        try {
            $product->update(
                $data
            );

            return redirect()->route('product.index')->with('message', 'Product Updated Successfull');
        } catch (\Exception $th) {
            return redirect()->route('product.edit', $product->id)->with('message', 'Problem with Database.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            
            $product->delete();
            unlink("images/".$product->thumb);
            return redirect()->route('product.index')->with('message', 'Product Deleted Successfull');

        } catch (\Throwable $th) {
            return redirect()->route('product.index')->with('error', 'Can\'t delete this product');
        }
    }

    
}
