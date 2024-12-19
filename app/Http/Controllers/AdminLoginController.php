<?php

namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            // Authentication passed
            return redirect()->intended('/admin/dashboard')->with('success', 'You are logged in successfully.');
        }

        // Authentication failed
        return redirect()->route('admin.login')->with('error', 'Invalid credentials');
    }
}
