<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class StaffMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {



        if (Auth::guard('staff')->check() /* && Auth::guard('staff')->user()->isAdmin() */) {
            // The staff member is logged in and is an admin
            return $next($request);
        } else {
            // Redirect or handle non-admin staff
            return redirect('/')->with('error', 'You do not have access to this area.');
        }

    }
}
