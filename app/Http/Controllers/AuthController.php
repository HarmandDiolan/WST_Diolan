<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function studentLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if (Auth::guard('student')->attempt($credentials)) {
            $request->session()->put('student_id', Auth::guard('student')->id()); // Save student ID
            return redirect()->intended('/grades');
        }
    
        return back()->withErrors(['email' => 'These credentials do not match our records.']);
    }
    
}
