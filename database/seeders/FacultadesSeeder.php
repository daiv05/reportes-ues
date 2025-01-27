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
                'nombre' => 'Facultad de Ingenería y Arquitectura',
                'activo' => true,
            ],
            [
                'id_sedes' => 1,
                'nombre' => 'Facultad de Ciencias y Humanidades',
                'activo' => false,
            ],
            [
                'id_sedes' => 2,
                'nombre' => 'Facultad Multidisciplinaria de Oriente',
                'activo' => false,
            ],
            [
                'id_sedes' => 1,
                'nombre' => 'Facultad de Agronomía',
                'activo' => false,
            ],
            [
                'id_sedes' => 1,
                'nombre' => 'Facultad de Odontología',
                'activo' => false,
            ],
            [
                'id_sedes' => 1,
                'nombre' => 'Facultad de Medicina',
                'activo' => false,
            ],
            [
                'id_sedes' => 3,
                'nombre' => 'Facultad Multidisciplinaria Paracentral',
                'activo' => false,
            ],
            [
                'id_sedes' => 1,
                'nombre' => 'Facultad de Jurisprudencia y Ciencias Sociales',
                'activo' => false,
            ],
            [
                'id_sedes' => 1,
                'nombre' => 'Facultad de Química y Farmacia',
                'activo' => false,
            ],
            [
                'id_sedes' => 1,
                'nombre' => 'Facultad de Ciencias Naturales y Matemática',
                'activo' => false,
            ],
            [
                'id_sedes' => 4,
                'nombre' => 'Facultad Multidisciplinaria de Occidente',
                'activo' => false,
            ],
            [
                'id_sedes' => 1,
                'nombre' => 'Facultad de Ciencias Económicas',
                'activo' => false,
            ]
        ];

        foreach ($facultades as $facultad) {
            Facultades::create($facultad);
        }
    }
}
