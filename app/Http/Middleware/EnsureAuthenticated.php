<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // checks the user if not authenticated, if it's not authenticated redirect to the login page
        // this function prevents the user to access the authorized pages (dashboard page) if the user is not logged in
        if (!Auth::check()) {
            return redirect('/login');
        }

        return $next($request);
    }
}
