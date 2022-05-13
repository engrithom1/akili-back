<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){

        $fields = $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'phonenumber' => 'required|string|max:15',
            'password' => 'required'
        ]);

        //$password = "1234567890";

        $user = User::create([
            'name' => $fields['name'],
            'phonenumber' => $fields['phonenumber'],
            'password' => bcrypt($fields['password'])
        ]); 

        $token = $user->createToken('apptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        /*$to = $fields['phonenumber'];
        $from = getenv("TWILIO_FROM");
        $message = 'Hello from akilishop! your password is'.$password;
        //open connection

        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, getenv("TWILIO_SID").':'.getenv("TWILIO_TOKEN"));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_URL, sprintf('https://api.twilio.com/2010-04-01/Accounts/'.getenv("TWILIO_SID").'/Messages.json', getenv("TWILIO_SID")));
        curl_setopt($ch, CURLOPT_POST, 3);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'To='.$to.'&From='.$from.'&Body='.$message);

        // execute post
        $result = curl_exec($ch);
        $result = json_decode($result);

        // close connection
        curl_close($ch);
        //Sending message ends here*/

        return response($response); 

    }

    ////////login

    public function login(Request $request){

        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string',
        ]);

        //check username
        $user = User::where('name',$fields['name'])->first();

        //check password
        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'error' => 'bad creds'
            ], 401);
        }

        $token = $user->createToken('apptoken')->plainTextToken;

        $response = [
            'token' => $token,
            'user' => $user
        ];

        return response($response); 

    }


    //////logout

    public function logout(Request $request){
        
        auth()->user()->tokens()->delete();

        return [
            'message' => 'logout'
        ];
    }

    public function currentUser(){
        return auth::user();
    }

}
