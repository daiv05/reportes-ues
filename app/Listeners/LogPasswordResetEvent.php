<?php

namespace App\Listeners;

use Illuminate\Auth\Events\PasswordReset;
use OwenIt\Auditing\Models\Audit;

class LogPasswordResetEvent
{
    public function handle(PasswordReset $event)
    {
        $user = $event->user;

        // Registrar la auditoría para el evento de restablecimiento de contraseña
        Audit::create([
            'user_id' => $user->id, // ID del usuario
            'event' => 'password_reset', // Tipo de evento
            'auditable_type' => 'App\Models\User', // Tipo de modelo
            'auditable_id' => $user->id, // ID del usuario
            'old_values' => [], // No hay valores previos para este evento
            'new_values' => [], // No hay nuevos valores directamente asociados
            'url' => request()->url(),
            'ip_address' => request()->ip(), // IP del usuario
            'agent' => request()->header('User-Agent'), // Información del navegador
        ]);
    }
}
