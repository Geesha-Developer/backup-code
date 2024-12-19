<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\AdminUser;

class AdminAuthController extends Controller
{

    // public function getLogin(){
    //     return view('admin.auth.login');
    // }

    // public function postLogin(Request $request)
    // {
    //     $this->validate($request, [
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);
    
    //     if (auth()->guard('admin')->attempt([
    //         'email' => $request->input('email'),
    //         'password' => $request->input('password')
    //     ])) {
    //         $user = auth()->guard('admin')->user();
    
    //         if ($user->is_admin == 1) {
    //             return redirect()->route('adminDashboard')->with('success', 'You are logged in successfully.');
    //         }
    //     }
    
    //     return back()->with('error', 'Whoops! Invalid email and password.');
    // }
    

        public function login(Request $req)
        {
            $submit = $req['submit'];
            if($submit == 'submit'){
                die('button press');
            }

            return view('admin.auth.login');
        }



    
}