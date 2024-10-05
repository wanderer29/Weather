<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (session('user_id')) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
