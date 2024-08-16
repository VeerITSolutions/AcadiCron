<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


use Illuminate\Support\Facades\Auth;
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has the admin role
        if (Auth::check() && Auth::user()->isAdmin()) { // Assuming `isAdmin()` method checks for admin role
            return $next($request);
        }

        // Redirect to login if not authenticated or not an admin
        return redirect('/')->with('error', 'You do not have access to this area.');
    }
}
