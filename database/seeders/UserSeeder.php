<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            [
                "id_persona" => 1,
                "carnet" => "aa00001",
                "email" => "aa00001@ues.edu.sv",
                "password" => bcrypt("password123")
            ],
            [
                "id_persona" => 2,
                "carnet" => "er00001",
                "email" => "er00001@ues.edu.sv",
                "password" => bcrypt("password123")
            ],
            [
                "id_persona" => 3,
                "carnet" => "er00002",
                "email" => "er00002@ues.edu.sv",
                "password" => bcrypt("password123")
            ],
            [
                "id_persona" => 4,
                "carnet" => "ed00001",
                "email" => "ed00001@ues.edu.sv",
                "password" => bcrypt("password123")
            ],
            [
                "id_persona" => 5,
                "carnet" => "ed00002",
                "email" => "ed00002@ues.edu.sv",
                "password" => bcrypt("password123")
            ],
            [
                "id_persona" => 6,
                "carnet" => "em00001",
                "email" => "em00001@ues.edu.sv",
                "password" => bcrypt("password123")
            ],
            [
                "id_persona" => 7,
                "carnet" => "em00002",
                "email" => "em00002@ues.edu.sv",
                "password" => bcrypt("password123")
            ],
            [
                "id_persona" => 8,
                "carnet" => "em00003",
                "email" => "em00003@ues.edu.sv",
                "password" => bcrypt("password123")
            ],
            [
                "id_persona" => 9,
                "carnet" => "em00004",
                "email" => "em00004@ues.edu.sv",
                "password" => bcrypt("password123")
            ],
            [
                "id_persona" => 10,
                "carnet" => "us00001",
                "email" => "us00001@ues.edu.sv",
                "password" => bcrypt("password123")
            ],
            [
                "id_persona" => 11,
                "carnet" => "us00002",
                "email" => "us00002@ues.edu.sv",
                "password" => bcrypt("password123")
            ],
            [
                "id_persona" => 12,
                "carnet" => "us00003",
                "email" => "us00003@ues.edu.sv",
                "password" => bcrypt("password123")
            ],
            [
                "id_persona" => 13,
                "carnet" => "us00004",
                "email" => "us00004@ues.edu.sv",
                "password" => bcrypt("password123")
            ],
        ];

        foreach ($usuarios as $usuario) {
            User::create($usuario);
        }
    }
}
