<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nette\Schema\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        if (Auth::attempt($request->only('email', 'password'))){
            return response()->json(['user' => Auth::user(), 'token' => Auth::user()->createToken('JWT')->plainTextToken], 200);
        }else{
            return response()->json('erro', 500);
        }
    }

    public function logout()
    {
        Auth::logout();
    }
    
}












