<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;
use OwenIt\Auditing\Models\Audit;

class LogUserVerifiedEvent
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Verified  $event
     * @return void
     */
    public function handle(Verified $event)
    {
        $user = $event->user; // Obtener el usuario verificado

        // Registrar la auditoría para el evento de verificación de correo electrónico
        Audit::create([
            'user_id' => $user->id, // ID del usuario verificado
            'event' => 'Vericar correo', // Tipo de evento
            'auditable_type' => 'App\Models\Seguridad\User', // Tipo de modelo (Usuario)
            'auditable_id' => $user->id, // ID del usuario
            'old_values' => [], // No hay valores anteriores para este evento
            'new_values' => [
                'email' => $user->email, // Correo electrónico del usuario
                'name' => $user->name,   // Nombre del usuario (si lo tienes)
            ],
            'url' => request()->url(), // URL desde la que se verificó el usuario
            'ip_address' => request()->ip(), // Dirección IP desde la que se verificó
            'user_agent' => request()->header('User-Agent'), // Agente de usuario (navegador)
        ]);
    }
}
