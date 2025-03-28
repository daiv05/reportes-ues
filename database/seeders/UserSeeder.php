<?php

namespace Database\Seeders;

use App\Models\Seguridad\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            [
                'id_persona' => 1,
                'carnet' => 'ricardo.guardado',
                'email' => 'ricardo.guardado@ues.edu.sv',
                'password' => bcrypt('pass123'),
                'role' => 'SUPERADMIN',
                'es_estudiante' => 0
            ]
        ];

        foreach ($usuarios as $usuario) {
            $user = User::create(
                [
                    'id_persona' => $usuario['id_persona'],
                    'carnet' => $usuario['carnet'],
                    'email' => $usuario['email'],
                    'password' => $usuario['password'],
                    'es_estudiante' => $usuario['es_estudiante'],
                    'id_escuela' => $usuario['id_escuela'] ?? null,
                    'email_verified_at' => Carbon::now()
                ]
            );
            $user->assignRole($usuario['role']);
        }
    }
}
