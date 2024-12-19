<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Assuming you have a role or permission system in place
        // and 'account' is a role or permission that grants access to these routes
        if (Auth::check() && Auth::user()->hasRole('account')) {
            return $next($request);
        }

        return redirect()->route('account.login')->with('error', 'You do not have access to this section.');
    }
}
