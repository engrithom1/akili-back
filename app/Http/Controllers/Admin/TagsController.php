<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tags;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tags::join('users','tags.user_id', '=', 'users.id')
                    ->select('users.name AS creator','tags.name','tags.id')
                    ->get();

        return view('tags.index',compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tags.create');
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
            'thumb' => 'required|mimes:jpg,png,jpeg|max:500'
        ]);

        $thumb = preg_replace('/\s+/', '', $request->thumb->getClientOriginalName());

        $thumb = time().'-'.$thumb;

        $request->thumb->move(public_path('images'), $thumb);

        $tags = Tags::create([
            'name' => $request->input('name'),
            'desc' => $request->input('desc'),
            'user_id' => Auth::user()->id,
            'thumb' => $thumb
        ]);

        return redirect()->route('tags.index')->with('message','Tag Created Successfull');
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
    public function edit(Tags $tag)
    {
        return view('tags.edit',compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tags $tag)
    {
        if(count($request->all()) == 5){
           
            $request->validate([
                'name' => 'required',
                'desc' => 'required',
                'thumb' => 'required|mimes:jpg,png,jpeg|max:500'
            ]);

            $thumb = preg_replace('/\s+/', '', $request->thumb->getClientOriginalName());

            $thumb = time().'-'.$thumb;
    
            $request->thumb->move(public_path('images'), $thumb);
//delete existing image
            unlink("images/".$tag->thumb);

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
            $tag->update(
                $data
            );

            return redirect()->route('tags.index')->with('message', 'Tags Updated Successfull');
        } catch (\Exception $th) {
            return redirect()->route('tags.edit', $tag->id)->with('message', 'Problem with Database.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tags $tag)
    {
        unlink("images/".$tag->thumb);
        $tag->delete();
        return redirect()->route('tags.index')->with('message', 'Tag Deleted Successfull');
    }
}
