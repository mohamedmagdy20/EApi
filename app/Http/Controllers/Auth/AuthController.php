<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 
use App\Models\User;
use  Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        // return User::all();
        $rule =[
            'email'=>'required|email',
            'password'=>'required'
        ];

        $validator = Validator::make($request->all(),$rule);

        if($validator->fails())
        {
            return response()->json([
                'error'=>$validator->errors(),
                'status'=>false
            ], 200);
        }
        $user = User::where('usr_mail',$request->email)->first();

      
        //check Password 
        if($user == null)
        {
            return response()->json([
                'msg'=>'Invail Email and Password',
                'status'=>false
            ], 200);
        }
        else
        {
              // Check Email and Password //
            

            $token = $user->createToken('myapptoken')->plainTextToken;

            $user->token = $token;

            return response()->json([
                'data'=>$user,
                'status'=>true
            ], 200);
        }

    }


}
