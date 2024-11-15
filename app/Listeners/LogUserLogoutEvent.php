<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use OwenIt\Auditing\Models\Audit;

class LogUserLogoutEvent
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $user = $event->user;  // Obtén el usuario autenticado
        $guard = $event->guard; // El guard utilizado para la autenticación

        // Registrar la auditoría para el evento de cierre de sesión
        Audit::create([
            'user_id' => $user->id, // ID del usuario que cerró sesión
            'event' => 'Cerrar session', // Tipo de evento
            'auditable_type' => 'App\Models\Seguridad\User', // Tipo de modelo (usuario)
            'auditable_id' => $user->id, // ID del usuario
            'old_values' => [], // No hay valores previos para este evento
            'new_values' => [
                'guard' => $guard, // El guard utilizado para la autenticación
                'email' => $user->email, // Correo del usuario
            ],
            'url' => request()->url(), // URL desde la que se realizó el logout
            'ip_address' => request()->ip(), // Dirección IP del usuario
            'user_agent' => request()->header('User-Agent'), // Información del agente de usuario (navegador)
        ]);
    }
}
