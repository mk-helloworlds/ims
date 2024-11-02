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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    protected $routeMiddleware = [
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ];

    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role->role_name === 'admin') {
            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'You are not authorized to access this page.');
    }
}
