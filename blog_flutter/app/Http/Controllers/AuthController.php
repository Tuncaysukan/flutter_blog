<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    //Register  user 

    public function register (Request $request)
    {
        $attr=$request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6|confirmed',
        ]);

        //create user  
        $user=User::create(
            [
                'name'=>$attr['name'],
                'email'=>$attr['email'],
                'password'=>bcrypt($attr['password']),
            ]
        );

        //return  token  - response 

        return response([
            'user'=>$user,
            'token'=>$user->createToken('secret')->plainTextToken
        ]);

    }

    //login  user 
    public function login (Request $request)
    {
        $attr=$request->validate([
     
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6',
        ]);

        //attempt  login 

        if (!Auth::attempt($attr)) {
           return response ([
               'message'=>'Hatalı  Giriş'
           ],403);
        }

        //return  token  - response 

        return response([
            'user'=>auth()->user(),
            'token'=>auth()->user()->createToken('secret')->plainTextToken
        ],200);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response (
        ['mesage '=>'Çıkış Tamam']
        );
    }

    //get  User  Details

    public function user( )
    {
        return response  (
        [
         'user'=>auth()->user()
        ],200);
    }
        
}
