<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use OwenIt\Auditing\Models\Audit;
use Illuminate\Support\Facades\Auth;

class LogLoginEvent
{
    public function handle(Login $event)
    {
        // Obtener el usuario que ha iniciado sesión
        $user = $event->user;

        // Registrar la auditoría para el evento de inicio de sesión
        Audit::create([
            'user_id' => $user->id, // ID del usuario
            'event' => 'login',      // Evento de login
            'auditable_type' => 'App\Models\Seguridad\User', // Tipo de modelo
            'auditable_id' => $user->id, // ID del usuario
            'old_values' => [],       // No hay valores anteriores para login
            'new_values' => [],       // No hay valores nuevos para login
            'url' => request()->url(), // URL actual
            'ip_address' => request()->ip(), // IP del usuario
            'user_agent' => request()->header('User-Agent'), // Información del navegador
        ]);
    }
}
