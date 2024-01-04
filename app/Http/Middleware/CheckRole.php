<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario tiene el rol deseado
        if (auth()->check()) {
            $roles = auth()->user()->roles;
            foreach ($roles as $role) {
                if ($role->id == 1) {
                    return $next($request);
                }
            }
        }

        // Redireccionar si el usuario no tiene el rol adecuado
        return redirect('/')->with('error', 'Acceso no autorizado.');
    }
}
