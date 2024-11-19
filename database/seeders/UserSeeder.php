<?php

namespace Database\Seeders;

use App\Models\Seguridad\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            [
                "id_persona" => 1,
                "carnet" => "aa11001",
                "email" => "aa11001@yopmail.com",
                "password" => bcrypt("pass123"),
                "role" => "ROLE_USUARIO_SUPER_ADMIN"
            ],
            [
                "id_persona" => 2,
                "carnet" => "rr11001",
                "email" => "rr11001@yopmail.com",
                "password" => bcrypt("pass123"),
                "role" => "ROLE_USUARIO_ADMIN_REPORTE"
            ],
            [
                "id_persona" => 3,
                "carnet" => "ss11001",
                "email" => "dc19019@ues.edu.sv",
                "password" => bcrypt("pass123"),
                "role" => "ROLE_USUARIO_SUPERVISOR_REPORTE"
            ],
            [
                "id_persona" => 4,
                "carnet" => "ss21001",
                "email" => "ss21001@yopmail.com",
                "password" => bcrypt("pass123"),
                "role" => "ROLE_USUARIO_SUPERVISOR_REPORTE"
            ],
            [
                "id_persona" => 5,
                "carnet" => "ee11001",
                "email" => "ee11001@yopmail.com",
                "password" => bcrypt("pass123"),
                "role" => "ROLE_USUARIO_EMPLEADO"
            ],
            [
                "id_persona" => 6,
                "carnet" => "ee21001",
                "email" => "ee21001@yopmail.com",
                "password" => bcrypt("pass123"),
                "role" => "ROLE_USUARIO_EMPLEADO"
            ],
            [
                "id_persona" => 7,
                "carnet" => "ee31001",
                "email" => "ee31001@yopmail.com",
                "password" => bcrypt("pass123"),
                "role" => "ROLE_USUARIO_EMPLEADO"
            ],
            [
                "id_persona" => 8,
                "carnet" => "ee41001",
                "email" => "ee41001@yopmail.com",
                "password" => bcrypt("pass123"),
                "role" => "ROLE_USUARIO_EMPLEADO"
            ],
            [
                "id_persona" => 9,
                "carnet" => "ee51001",
                "email" => "ee51001@yopmail.com",
                "password" => bcrypt("pass123"),
                "role" => "ROLE_USUARIO_EMPLEADO"
            ],
            [
                "id_persona" => 10,
                "carnet" => "ee61001",
                "email" => "ee61001@yopmail.com",
                "password" => bcrypt("pass123"),
                "role" => "ROLE_USUARIO_EMPLEADO"
            ],
            [
                "id_persona" => 11,
                "carnet" => "nn1101",
                "email" => "nn11001@yopmail.com",
                "password" => bcrypt("pass123"),
                "role" => "ROLE_USUARIO_BASE"
            ],
            [
                "id_persona" => 12,
                "carnet" => "nn2101",
                "email" => "nn21001@yopmail.com",
                "password" => bcrypt("pass123"),
                "role" => "ROLE_USUARIO_BASE"
            ],
            [
                "id_persona" => 13,
                "carnet" => "nn3101",
                "email" => "nn31001@yopmail.com",
                "password" => bcrypt("pass123"),
                "role" => "ROLE_USUARIO_BASE"
            ],
            [
                "id_persona" => 14,
                "carnet" => "nn4101",
                "email" => "nn41001@yopmail.com",
                "password" => bcrypt("pass123"),
                "role" => "ROLE_USUARIO_BASE"
            ],
        ];

        foreach ($usuarios as $usuario) {
            $user = User::create(
                [
                    "id_persona" => $usuario["id_persona"],
                    "carnet" => $usuario["carnet"],
                    "email" => $usuario["email"],
                    "password" => $usuario["password"]
                ]
            );
            $user->assignRole($usuario["role"]);
        }
    }
}
