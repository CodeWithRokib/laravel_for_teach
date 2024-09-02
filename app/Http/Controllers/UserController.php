<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        
    }
    public function register(Request $request){
        $request->validate([
            "name" => 'required|string|max:255',
            "email" => 'required|string|unique:users|max:255',
            "password" => 'required|string|max:5|confirmed',
        ]);

        $user = User::create([
              'name'=>$request->name,
              'email'=>$request->email,
              'password'=>Hash::make($request->password),
        ]);
        return redirect()->back();
    }

    public function login(Request $request){
           $request->validate([
              "email" => 'required|string|email',
              "password" => 'required',
           ]);
           $userCredential = $request->only('email','password');
           if(Auth::attempt($userCredential)){
            return redirect('/dashboard');
           }else{
            return back()->with('error','email and password is incorrect');
           }
    }

}
