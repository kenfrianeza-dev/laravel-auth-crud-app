<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // checks the user if authenticated, if it's authenticated redirect to the dashboard page
        // this function prevents the user from going back to the guest pages(login/register page) if the user is logged in
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
