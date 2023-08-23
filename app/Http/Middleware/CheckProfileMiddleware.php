<?php

namespace App\Http\Middleware;

use Closure;

class CheckProfileMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$profiles)
    {
        $currentProfile = $request->user()->profile->name;

        $isAdmin = $currentProfile === 'admin';
        if ($isAdmin) {
            return $next($request);
        }

        if (in_array($currentProfile, $profiles)) {
            return $next($request);
        }

        abort(403, 'Acesso não autorizado.');
    }
}
