<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use OwenIt\Auditing\Models\Audit;
use Illuminate\Support\Facades\Auth;

class LogAuthenticationEvents
{
    public function handle(Login $event)
    {
        $user = $event->user;

        // Registrar la auditoría manualmente
        Audit::create([
            'user_id' => $user->id, // ID del usuario que inició sesión
            'event' => 'login',      // Tipo de evento
            'auditable_type' => 'App\Models\User', // El modelo relacionado
            'auditable_id' => $user->id, // El ID del modelo
            'old_values' => [], // No hay valores previos para el inicio de sesión
            'new_values' => [], // No hay nuevos valores específicos
            'url' => request()->url(), // URL actual
            'ip_address' => request()->ip(), // IP del usuario
            'agent' => request()->header('User-Agent'), // Agente de usuario (navegador)
        ]);
    }
}
