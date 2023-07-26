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
        $suppliesGroup = (bool)$request->query('suppliesGroup');
        $isAllowedGroup = in_array($suppliesGroup, $allowedSuppliesGroups);

        if (!$isAdmin && !$suppliesGroup) {
            abort(400, 'Parâmetro obrigatório para perfis não administrativos. [Parâmetro: suppliesGroup]');
        }

        if ($suppliesGroup && !$isAllowedGroup) {
            abort(403, 'Acesso não autorizado para o grupo de suprimentos.');
        }

        return $next($request);
    }
}
