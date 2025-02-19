<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdminEmail
{
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $userEmail = Auth::user()->email;
            $firmEmail = Auth::user()->firm_id . '@gmail.com';
    
            // Allow access if the email matches either condition
            if ($userEmail === 'datahouset@gmail.com' || $userEmail === $firmEmail) {
                return $next($request);
            }
        }
    
        // Redirect or abort if the user is not authorized
        return redirect('/login')->with('error', 'You are not authorized to access this page.');
    }
    
}
