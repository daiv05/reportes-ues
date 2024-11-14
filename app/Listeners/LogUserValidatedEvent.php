<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Validated;
use OwenIt\Auditing\Models\Audit;

class LogUserValidatedEvent
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Validated  $event
     * @return void
     */
    public function handle(Validated $event)
    {
        $user = $event->user; // Obtener el usuario validado

        // Registrar la auditoría para el evento de validación
        Audit::create([
            'user_id' => $user->id, // ID del usuario validado
            'event' => 'user_validated', // Tipo de evento
            'auditable_type' => 'App\Models\User', // Tipo de modelo (Usuario)
            'auditable_id' => $user->id, // ID del usuario
            'old_values' => [], // No hay valores anteriores para este evento
            'new_values' => [
                'email' => $user->email, // Correo electrónico del usuario
                'name' => $user->name,   // Nombre del usuario (si lo tienes)
            ],
            'url' => request()->url(), // URL desde la que se validó el usuario
            'ip_address' => request()->ip(), // Dirección IP desde la que se validó
            'user_agent' => request()->header('User-Agent'), // Agente de usuario (navegador)
        ]);
    }
}
