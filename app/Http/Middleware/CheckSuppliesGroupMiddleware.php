<?php

namespace App\Http\Middleware;

use Closure;

class CheckSuppliesGroupMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$allowedSuppliesGroups)
    {
        $isAdmin = auth()->user()->profile->name === 'admin';
        $currentProfile = auth()->user()->profile->name;
        $isAllowedProfile = collect($allowedSuppliesGroups)->contains($currentProfile);

        if (!$isAdmin && !$isAllowedProfile) {
            abort(403, 'Acesso não autorizado para o grupo de suprimentos.');
        }

        return $next($request);
    }
}
