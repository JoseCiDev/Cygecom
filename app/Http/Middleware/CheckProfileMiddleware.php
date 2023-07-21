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
    public function handle($request, Closure $next, $profile)
    {
        $isAdmin = $request->user()->profile->name === 'admin';

        if ($isAdmin || $request->user()->profile->name === $profile) {
            return $next($request);
        }

        abort(403, 'Acesso não autorizado.');
    }
}
