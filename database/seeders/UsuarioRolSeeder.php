<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\Seguridad\User;
use Illuminate\Database\Seeder;

class UsuarioRolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolesUsuarios = [
            [
                'id_usuario' => 1,
                'rol' => RolesEnum::SUPERADMIN
            ],
            [
                'id_usuario' => 2,
                'rol' => RolesEnum::ENCARGADO_REPORTE
            ],
            [
                'id_usuario' => 3,
                'rol' => RolesEnum::ENCARGADO_REPORTE
            ],
            [
                'id_usuario' => 4,
                'rol' => RolesEnum::ENCARGADO_DEPARTAMENTO
            ],
            [
                'id_usuario' => 5,
                'rol' => RolesEnum::ENCARGADO_DEPARTAMENTO
            ],
            [
                'id_usuario' => 6,
                'rol' => RolesEnum::EMPLEADO
            ],
            [
                'id_usuario' => 7,
                'rol' => RolesEnum::EMPLEADO
            ],
            [
                'id_usuario' => 8,
                'rol' => RolesEnum::EMPLEADO
            ],
            [
                'id_usuario' => 9,
                'rol' => RolesEnum::EMPLEADO
            ],
            [
                'id_usuario' => 10,
                'rol' => RolesEnum::USUARIO
            ],
            [
                'id_usuario' => 11,
                'rol' => RolesEnum::USUARIO
            ],
            [
                'id_usuario' => 12,
                'rol' => RolesEnum::USUARIO
            ],
            [
                'id_usuario' => 13,
                'rol' => RolesEnum::USUARIO
            ]
        ];

        foreach ($rolesUsuarios as $rolUsuario) {
            $user = User::findOrFail($rolUsuario['id_usuario']);
            $user->assignRole($rolUsuario['rol']);
        }
    }
}
