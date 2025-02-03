<?php

namespace Database\Seeders;

use App\Models\Reportes\Bien;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bien = [
            [
                'id_tipo_bien' => 6,
                'id_estado_bien' => 1,
                'nombre' => 'Silla Reclinable',
                'descripcion' => 'Silla que se reclina, tipo secretarial',
                'codigo' => 'S-6010'
            ],
            [
                'id_tipo_bien' => 2,
                'id_estado_bien' => 1,
                'nombre' => 'Lámpara Zona B',
                'descripcion' => 'Lámpara de la zona B, atrás del edifico B',
                'codigo' => 'L-3015'
            ],
            [
                'id_tipo_bien' => 7,
                'id_estado_bien' => 1,
                'nombre' => 'Baño 1 C11',
                'descripcion' => 'Baño de la primera planta Edificio C, cerca del salón C11',
                'codigo' => 'B-0011'
            ]

        ];

        foreach($bien as $b) {
            Bien::create($b);
        }
          
    }
}
