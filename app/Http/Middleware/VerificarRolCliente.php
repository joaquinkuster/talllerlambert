<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarRolCliente
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica si el usuario está autenticado y si tiene el rol 'Cliente'
        if (auth()->check() && auth()->user()->rol === 'Cliente') {
            return $next($request); // Permite el acceso a la siguiente acción
        }

        // La funcionalidad no está definida para el administrador
        return redirect()->route('servicios')->with('error', 'Esta funcionalidad no está disponible para tu rol. Solo los clientes pueden acceder a esta sección.');
    }
}
