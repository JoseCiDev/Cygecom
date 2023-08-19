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
        $suppliesGroup = $request->query('suppliesGroup');

        $isAllowedProfile = collect($allowedSuppliesGroups)->contains($currentProfile);

        if (!$isAdmin && !$suppliesGroup) {
            abort(400, 'Parâmetro obrigatório para perfis não administrativos. [Parâmetro: suppliesGroup]');
        }

        if (!$isAdmin && !$isAllowedProfile) {
            abort(403, 'Acesso não autorizado para o grupo de suprimentos.');
        }

        return $next($request);
    }
}
