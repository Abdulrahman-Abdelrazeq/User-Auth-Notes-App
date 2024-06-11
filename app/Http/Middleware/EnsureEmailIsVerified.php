<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureEmailIsVerified
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
        // Check if the user is logged in and if the email is verified
        if (Auth::check() && !Auth::user()->hasVerifiedEmail()) {
            // Redirect to a specific route or return a response
            return redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
