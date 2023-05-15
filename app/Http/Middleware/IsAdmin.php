<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->profile->name === 'admin') {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'Unauthorized action.');
    }
}
