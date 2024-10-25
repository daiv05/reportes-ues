<?php

namespace Database\Seeders;

use App\Models\rhu\Puesto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $puestos = [
            [
                'nombre' => 'Carpintero 1',
                'id_entidad' => 1
            ],
            [
                'nombre' => 'Electricista 1',
                'id_entidad' => 2
            ],
            [
                'nombre' => 'Carpintero 2',
                'id_entidad' => 2
            ]
        ];

        foreach ($puestos as $p) {
            Puesto::create($p);
        }
    }
}
