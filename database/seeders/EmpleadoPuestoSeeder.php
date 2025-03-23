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
                "id_puesto" => 1
            ]
        ];

        foreach ($empleados as $ep) {
            EmpleadoPuesto::create($ep);
        }
    }
}
