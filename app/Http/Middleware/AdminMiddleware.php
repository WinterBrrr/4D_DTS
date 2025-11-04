<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminMiddleware
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
        // Check if user is logged in
        if (Session::get('logged_in') !== true) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        // Check if user has admin role
        if (Session::get('user_role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'You do not have admin privileges.');
        }

        return $next($request);
    }
}