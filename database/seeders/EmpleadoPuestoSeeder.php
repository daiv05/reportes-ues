<?php

namespace Database\Seeders;

use App\Models\rhu\EmpleadoPuesto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpleadoPuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $empleados = [
            [
                "id_usuario" => 1,
                "id_puesto" => 2
            ],
            [
                "id_usuario" => 2,
                "id_puesto" => 2
            ],
            [
                "id_usuario" => 3,
                "id_puesto" => 7
            ],
            [
                "id_usuario" => 4,
                "id_puesto" => 7
            ],
            [
                "id_usuario" => 5,
                "id_puesto" => 8
            ],
            [
                "id_usuario" => 6,
                "id_puesto" => 12
            ],
            [
                "id_usuario" => 7,
                "id_puesto" => 10
            ],
            [
                "id_usuario" => 8,
                "id_puesto" => 10
            ],
            [
                "id_usuario" => 9,
                "id_puesto" => 14
            ],
            [
                "id_usuario" => 10,
                "id_puesto" => 14
            ]
        ];

        foreach ($empleados as $ep) {
            EmpleadoPuesto::create($ep);
        }
    }
}
