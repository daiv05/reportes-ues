<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class ValidateUser
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Usuario activo
        $validUser = true;
        if ($user->activo === 0) {
            $message = 'El usuario no se encuentra activo dentro del sistema';
            $validUser = false;
        }
        // Posee al menos un rol activo
        $validRole = 0;
        $user->roles->each(function ($rol) use (&$validRole) {
            if ($rol->activo === 1) {
                $validRole++;
            }
        });
        if (! $validRole) {
            $message = 'El usuario no posee un rol activo dentro del sistema';
            $validUser = false;
        }
        if (! $user->es_estudiante) {
            // Si es empleado: posee al menos un puesto activo
            $validPuesto = 0;
            $user->empleadosPuestos->each(function ($empPuesto) use (&$validPuesto) {
                if ($empPuesto->activo === 1) {
                    $validPuesto++;
                }
            });
            if (! $validPuesto) {
                $message = 'El usuario no posee un puesto activo dentro del sistema';
                $validUser = false;
            }
        } else {
            // Si es estudiante: la escuela a la que pertenece está activa
            if ($user->escuela->activo === 0) {
                $message = 'La escuela a la que pertenece el usuario no se encuentra activa dentro del sistema';
                $validUser = false;
            }
        }

        if (! $validUser) {
            $request->session()->flush();
            return redirect()->route('login')->with('message', [
                'type' => 'error',
                'content' => $message
            ]);
        }

        return $next($request);
    }
}
