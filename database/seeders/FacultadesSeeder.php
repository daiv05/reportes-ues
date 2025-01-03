<?php

namespace Database\Seeders;

use App\Models\General\Facultades;
use Illuminate\Database\Seeder;

class FacultadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $facultades = [
            [
                'id_sedes' => 1,
                'nombre' => 'Facultad de Ciencias y Humanidades',
            ],
            [
                'id_sedes' => 2,
                'nombre' => 'Facultad Multidisciplinaria de Oriente',
                'activo' => false,
            ],
            [
                'id_sedes' => 1,
                'nombre' => 'Facultad de Ingenería y Arquitectura',
            ],
            [
                'id_sedes' => 1,
                'nombre' => 'Facultad de Agronomía',
            ],
            [
                'id_sedes' => 1,
                'nombre' => 'Facultad de Odontología',
            ],
            [
                'id_sedes' => 1,
                'nombre' => 'Facultad de Medicina',
            ],
            [
                'id_sedes' => 3,
                'nombre' => 'Facultad Multidisciplinaria Paracentral',
                'activo' => false,
            ],
            [
                'id_sedes' => 1,
                'nombre' => 'Facultad de Jurisprudencia y Ciencias Sociales',
            ],
            [
                'id_sedes' => 1,
                'nombre' => 'Facultad de Química y Farmacia',
            ],
            [
                'id_sedes' => 1,
                'nombre' => 'Facultad de Ciencias Naturales y Matemática',
            ],
            [
                'id_sedes' => 4,
                'nombre' => 'Facultad Multidisciplinaria de Occidente',
            ],
            [
                'id_sedes' => 1,
                'nombre' => 'Facultad de Ciencias Económicas',
            ]
        ];

        foreach ($facultades as $facultad) {
            Facultades::create($facultad);
        }
    }
}
