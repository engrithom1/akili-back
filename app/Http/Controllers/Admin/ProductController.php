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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodz = Product::all();
        $products = ProductResource::collection($prodz);

        
        return view('product.index',compact('products'));
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

        $thumb = str_replace("-", " ", $request->thumb->getClientOriginalName());

        $thumb = time().'-'.$thumb;

        $request->thumb->move(public_path('images'), $thumb);

        $product = Product::create([
            'name' => $request->input('name'),
            'desc' => $request->input('desc'),
            'price' => $request->input('price'),
            'tag' => $request->input('tags'),
            'category_id' => $request->input('category'),
            'discount_id' => $request->input('discount'),
            'user_id' => Auth::user()->id,
            'thumb' => $thumb
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
        //
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
        if(count($request->all()) == 9){
           
            $request->validate([
                'name' => 'required',
                'desc' => 'required',
                'thumb' => 'required|mimes:jpg,png,jpeg|max:500',
                'category' => 'required',
                'discount' => 'required',
                'price' => 'required',
                'tags' => 'required'
            ]);

            $thumb = str_replace(" ", "-", $request->thumb->getClientOriginalName());

            $thumb = time().'-'.$thumb;
    
            $request->thumb->move(public_path('images'), $thumb);
//delete existing image
            unlink("images/".$category->thumb);

            $data = [
                'name' => $request->input('name'),
                'desc' => $request->input('desc'),
                'price' => $request->input('price'),
                'tag' => $request->input('tags'),
                'category_id' => $request->input('category'),
                'discount_id' => $request->input('discount'),
                'user_id' => Auth::user()->id,
                'thumb' => $thumb
            ];

        }else{
           
            $request->validate([
                'name' => 'required',
                'desc' => 'required',
                'category' => 'required',
                'discount' => 'required',
                'price' => 'required',
                'tags' => 'required'
            ]);

            $data = [
                'name' => $request->input('name'),
                'desc' => $request->input('desc'),
                'price' => $request->input('price'),
                'tag' => $request->input('tags'),
                'category_id' => $request->input('category'),
                'discount_id' => $request->input('discount'),
                'user_id' => Auth::user()->id,
                
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
        unlink("images/".$product->thumb);
        $product->delete();
        return redirect()->route('product.index')->with('message', 'Product Deleted Successfull');
    }
}
