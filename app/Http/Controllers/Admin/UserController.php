<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Level;

class UserController extends Controller
{
    public function admins(){

        $admins = User::where('level_id','>=','2')->get();

        return view('user.admins',compact('admins'));
    }

    public function Subscribers(Request $request){

        $subscribers = User::where('level_id','1')->paginate(10);

        if ($request->has('search')) {

            $subscribers = User::where('level_id','1')
                         ->where('name','like',"%{$request->search}%")
                         ->orWhere('fullname','like',"%{$request->search}%")
                         ->orWhere('phonenumber','like',"%{$request->search}%")
                         ->orWhere('region','like',"%{$request->search}%")
                         ->paginate(10);
        }

        return view('user.subscribers',compact('subscribers'));
    }

    public function Permissions(){

        $roles = Level::with('users')->get();
        
        return view('user.permissions',compact('roles'));
    }
}
