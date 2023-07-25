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
        $suppliesGroup = $request->route('suppliesGroup');
        if (in_array($suppliesGroup, $allowedSuppliesGroups)) {
            return $next($request);
        }

        abort(403, 'Acesso não autorizado para o grupo de suprimentos.');
    }
}
