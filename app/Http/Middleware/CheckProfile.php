<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckProfile
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->profile->profile_name === 'admin') {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'Unauthorized action.');
    }
}
