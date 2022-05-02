<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discount;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts = Discount::all();
        return view('discount.index',compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('discount.create');
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
            'percent' => 'required|numeric|max:99|min:0'
        ]);

        $discount = Discount::create([
            'name' => $request->input('name'),
            'desc' => $request->input('desc'),
            'user_id' => Auth::user()->id,
            'percent' => $request->input('percent'),
            
        ]);

        return redirect()->route('discount.index')->with('message','Discount Created Successfull');
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
    public function edit(Discount $discount)
    {
        return view('discount.edit', compact('discount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Discount $discount)
    {
        $request->validate([
            'name' => 'required',
            'desc' => 'required',
            'percent' => 'required|numeric|max:99|min:0'
        ]);

        $data = [
            'name' => $request->input('name'),
            'desc' => $request->input('desc'),
            'user_id' => Auth::user()->id,
            'percent' => $request->input('percent'),
            
        ];

        try {
            $discount->update(
                $data
            );

            return redirect()->route('discount.index')->with('message', 'Discount Updated Successfull');
        } catch (\Exception $th) {
            return redirect()->route('discount.edit', $discount->id)->with('errorz', 'Problem with Database.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount $discount)
    {
        try {
            $discount->delete();

            return redirect()->route('discount.index')->with('message', 'Discount Deleted Successfull');
        } catch (\Exception $th) {
            return redirect()->route('discount.index')->with('errorz', 'This discount holds products cant be deleted');
        }
        
    }
}
