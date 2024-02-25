<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(){
        return view('pages.auth.index', ['title' => 'Login']);
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'username' => 'required|exists:users,username',
            'password' => 'required|matched',
        ], [
            'username.exists' => 'There is no such username.',
            'password.matched' => 'The password does not match with the username.',
        ]);

        $remember = $request->has('remember');

        if(Auth::attempt($credentials, $remember)){
            $request->session()->regenerate();
    
            return redirect()->intended('/');
        }
    
        return back()->with('failed', 'Login failed!');
    }

    public function logout(){
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/login');
    }
}
