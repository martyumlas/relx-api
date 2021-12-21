<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);      

        if (Auth::attempt($credentials)) {            
            return response()->json(['user' => auth()->user()]);
        }

        return response()->json([ 'error' => 'The provided credentials do not match our records.'], 401);
    } 

    public function logout()
    {
        Auth::guard('web')->logout();

        return response()->json(['message' => 'Logout Successfull']);
    }
}


