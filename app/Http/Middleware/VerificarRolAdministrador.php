<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarRolAdministrador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica si el usuario está autenticado y si tiene el rol 'Administrador'
        if (auth()->check() && auth()->user()->rol === 'Administrador') {
            return $next($request); // Permite el acceso a la siguiente acción
        }

        // Si no tiene el rol, redirige a la página de inicio o a donde quieras
        return redirect()->route('servicios')->with('error', 'No tienes permiso para acceder a esta sección.');
    }
}
