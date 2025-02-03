<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       
        $user = auth()->user();

        if ($user && !$user->isAdmin()) {
            abort(403);
        } elseif (!$user) {
            // If no user is logged in, handle this scenario (e.g., redirect to login)
            return redirect()->route('login');
        }
        
        
        return $next($request);
    }
}
