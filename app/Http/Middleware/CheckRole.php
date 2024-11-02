<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */


    public function handle($request, Closure $next, ...$roles)
    {
        $user = $request->user();

        // Ensure the user is authenticated and their role is one of the accepted roles
        if (!$user || !in_array($user->role->role_name, $roles)) {
            return redirect('/unauthorized');
        }

        return $next($request); 
    }
}
