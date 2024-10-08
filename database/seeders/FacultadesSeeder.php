<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Facultades;

class FacultadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        // Facultad de Ciencias y Humanidades
        // Facultad Multidisciplinaria de Oriente
        // Facultad de Ingeníeria y Arquitectura
        // Facultad de Agronomía
        // Facultad de Odontología
        // Facultad de Medicina
        // Facultad Multidisciplinaria Paracentral
        // Facultad de Jurisprudencia y Ciencias Sociales
        // Facultad de Química y Farmacia
        // Facultad de Ciencias Naturales y Matemática
        // Facultad Multidisciplinaria de Occidente
        // Facultad de Ciencias Económicas
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
                'nombre' => 'Facultad de Ingeníeria y Arquitectura',
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
