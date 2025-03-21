<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow guests to access (so they can see the login page)
        if (!$request->user()) {
            return $next($request);
        }
    
        // If logged in, only allow admins
        if ($request->user()->type !== 'admin') {
            abort(403, 'Access denied. Admins only.');
        }
    
        return $next($request);
    }
}
