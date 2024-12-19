<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class SuperAdminController extends Controller
{
    // Other methods

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            // Authentication passed
            return redirect()->intended('/dashboard');
        }
    
        // Authentication failed
        return back()->with('error', 'The provided credentials do not match our records.')->withInput($request->only('email'));
    }
    

    
    public function showLoginForm()
    {
        return view('superadmin.login');
    }

    public function dashboard()
    {
        // Your dashboard logic here
        return view('superadmin.dashboard');
    }
}
