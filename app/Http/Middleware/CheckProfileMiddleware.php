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
        $isAdmin = $request->user()->profile->name === 'admin';

        if ($isAdmin || in_array($request->user()->profile->name, $profiles)) {
            return $next($request);
        }

        abort(403, 'Acesso não autorizado.');
    }
}
