<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use OwenIt\Auditing\Models\Audit;

class LogUserRegisteredEvent
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $user = $event->user; // Obtén el usuario registrado

        // Registrar la auditoría para el evento de registro
        Audit::create([
            'user_id' => $user->id, // ID del usuario registrado
            'event' => 'Registro', // Tipo de evento
            'auditable_type' => 'App\Models\Seguridad\User', // Tipo de modelo (usuario)
            'auditable_id' => $user->id, // ID del usuario
            'old_values' => [], // No hay valores previos para este evento
            'new_values' => [
                'email' => $user->email, // Correo del usuario
                'name' => $user->name,   // Nombre del usuario (si lo tienes)
            ],
            'url' => request()->url(), // URL desde la que se registró
            'ip_address' => request()->ip(), // Dirección IP del usuario
            'user_agent' => request()->header('User-Agent'), // Información del agente de usuario (navegador)
        ]);
    }
}
