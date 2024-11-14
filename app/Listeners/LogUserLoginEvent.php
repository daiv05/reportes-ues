<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use OwenIt\Auditing\Models\Audit;

class LogUserLoginEvent
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;  // Obtén el usuario autenticado
        $guard = $event->guard; // El guard utilizado para la autenticación
        $remember = $event->remember; // Si el usuario eligió "recordarme"

        // Registrar la auditoría para el evento de inicio de sesión
        Audit::create([
            'user_id' => $user->id, // ID del usuario que inició sesión
            'event' => 'user_logged_in', // Tipo de evento
            'auditable_type' => 'App\Models\User', // Tipo de modelo (usuario)
            'auditable_id' => $user->id, // ID del usuario
            'old_values' => [], // No hay valores previos para este evento
            'new_values' => [
                'guard' => $guard, // El guard utilizado para la autenticación
                'remember' => $remember, // Si el usuario eligió "recordarme"
                'email' => $user->email, // Correo del usuario
            ],
            'url' => request()->url(), // URL desde la que se realizó el login
            'ip_address' => request()->ip(), // Dirección IP del usuario
            'user_agent' => request()->header('User-Agent'), // Información del agente de usuario (navegador)
        ]);
    }
}
