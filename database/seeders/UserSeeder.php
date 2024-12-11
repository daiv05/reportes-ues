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
                "role" => "SUPERADMIN"
            ],
            [
                "id_persona" => 2,
                "carnet" => "rr11001",
                "email" => "rr11001@yopmail.com",
                "password" => bcrypt("pass123"),
                "role" => "ADMINISTRADOR DE REPORTES"
            ],
            [
                "id_persona" => 3,
                "carnet" => "ss11001",
                "email" => "dc19019@ues.edu.sv",
                "password" => bcrypt("pass123"),
                "role" => "SUPERVISOR"
            ],
            [
                "id_persona" => 4,
                "carnet" => "ss21001",
                "email" => "ss21001@yopmail.com",
                "password" => bcrypt("pass123"),
                "role" => "SUPERVISOR"
            ],
            [
                "id_persona" => 5,
                "carnet" => "ee11001",
                "email" => "ee11001@yopmail.com",
                "password" => bcrypt("pass123"),
                "role" => "EMPLEADO"
            ],
            [
                "id_persona" => 6,
                "carnet" => "ee21001",
                "email" => "ee21001@yopmail.com",
                "password" => bcrypt("pass123"),
                "role" => "EMPLEADO"
            ],
            [
                "id_persona" => 7,
                "carnet" => "ee31001",
                "email" => "ee31001@yopmail.com",
                "password" => bcrypt("pass123"),
                "role" => "EMPLEADO"
            ],
            [
                "id_persona" => 8,
                "carnet" => "ee41001",
                "email" => "ee41001@yopmail.com",
                "password" => bcrypt("pass123"),
                "role" => "EMPLEADO"
            ],
            [
                "id_persona" => 9,
                "carnet" => "ee51001",
                "email" => "ee51001@yopmail.com",
                "password" => bcrypt("pass123"),
                "role" => "EMPLEADO"
            ],
            [
                "id_persona" => 10,
                "carnet" => "ee61001",
                "email" => "ee61001@yopmail.com",
                "password" => bcrypt("pass123"),
                "role" => "EMPLEADO"
            ],
            [
                "id_persona" => 11,
                "carnet" => "nn11001",
                "email" => "nn11001@yopmail.com",
                "password" => bcrypt("pass123"),
                "role" => "USUARIO"
            ],
            [
                "id_persona" => 12,
                "carnet" => "nn21001",
                "email" => "nn21001@yopmail.com",
                "password" => bcrypt("pass123"),
                "role" => "USUARIO"
            ],
            [
                "id_persona" => 13,
                "carnet" => "nn31001",
                "email" => "nn31001@yopmail.com",
                "password" => bcrypt("pass123"),
                "role" => "USUARIO"
            ],
            [
                "id_persona" => 14,
                "carnet" => "nn41001",
                "email" => "nn41001@yopmail.com",
                "password" => bcrypt("pass123"),
                "role" => "USUARIO"
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
