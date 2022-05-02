<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File; 
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        //$categories = Category::withCount('products')->get();
        return view('category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //methodes
        //guessExtension()
        //guessClientExtension()
        //getMimeType()
        //store()
        //asStore()
        //storePublicly()
        //move()
        //getClientOriginalName()
        //getClientMimeType()
        //getSize()
        //getError()
        //getValid()
        //$test = $request->file('image')->getMimeType();
       
        $request->validate([
            'name' => 'required',
            'desc' => 'required',
            'thumb' => 'required|mimes:jpg,png,jpeg|max:500'
        ]);

        $thumb = str_replace("-", " ", $request->thumb->getClientOriginalName());

        $thumb = time().'-'.$thumb;

        $request->thumb->move(public_path('images'), $thumb);

        $category = Category::create([
            'name' => $request->input('name'),
            'desc' => $request->input('desc'),
            'user_id' => Auth::user()->id,
            'thumb' => $thumb
        ]);

        return redirect()->route('category.index')->with('message','Category Created Successfull');
        
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
    public function edit(Category $category)
    {
        return view('category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        
        //dd(array_key_exists('_method',$request->all()));
 
        if(count($request->all()) == 5){
           
            $request->validate([
                'name' => 'required',
                'desc' => 'required',
                'thumb' => 'required|mimes:jpg,png,jpeg|max:500'
            ]);

            $thumb = str_replace(" ", "-", $request->thumb->getClientOriginalName());

            $thumb = time().'-'.$thumb;
    
            $request->thumb->move(public_path('images'), $thumb);
//delete existing image
            unlink("images/".$category->thumb);

            $data = [
                'name' => $request->name,
                'desc' => $request->desc,
                'user_id' => Auth::user()->id,
                'thumb' => $thumb
            ];

        }else{
           
            $request->validate([
                'name' => 'required',
                'desc' => 'required',
            ]);

            $data = [
                'name' => $request->name,
                'desc' => $request->desc,
                'user_id' => Auth::user()->id,
                
            ];
        }

        try {
            $category->update(
                $data
            );

            return redirect()->route('category.index')->with('message', 'Category Updated Successfull');
        } catch (\Exception $th) {
            return redirect()->route('category.edit', $category->id)->with('errorz', 'Problem with Database.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        
        try {
            unlink("images/".$category->thumb);
            $category->delete();

            return redirect()->route('category.index')->with('message', 'Category Deleted Successfull');
        } catch (\Exception $th) {
            return redirect()->route('category.index')->with('errorz', 'This category holds products cant be deleted');
        }
    }
}
