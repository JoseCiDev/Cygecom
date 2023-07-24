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
        $suppliesGroup = $request->route('suppliesGroup');

        $isAdmin = $currentProfile === 'admin';
        if ($isAdmin) {
            return $next($request);
        }

        if (in_array($currentProfile, $profiles)) {
            if (!$suppliesGroup) {
                return $next($request);
            }

            $isAuthInp = $currentProfile === 'suprimentos_inp' && $suppliesGroup === 'inp';
            $isAuthHkm = $currentProfile === 'suprimentos_hkm' && $suppliesGroup === 'hkm';
            if ($suppliesGroup && ($isAuthInp || $isAuthHkm)) {;
                return $next($request);
            }
        }

        abort(403, 'Acesso não autorizado.');
    }
}
