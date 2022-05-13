<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()){
        $leveid = auth::user()->level_id;

        //return $leveid;

        if($leveid == 1){
            //return redirect('/unauthorized');
            return view('dashbord.unauth');

        }
        return view('dashbord.admin');
       }
       return redirect('/login');
    }

    
}
