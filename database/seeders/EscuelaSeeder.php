<?php

namespace Database\Seeders;

use App\Models\Mantenimientos\Escuela;
use Illuminate\Database\Seeder;

class EscuelaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $escuelas = [
            [
                'id_facultad' => 3,
                'nombre' => 'Arquitectura',
            ],
            [
                'id_facultad' => 3,
                'nombre' => 'Ingeniería Civil',
            ],
            [
                'id_facultad' => 3,
                'nombre' => 'Ingeniería de Sistemas Informáticos',
            ],
            [
                'id_facultad' => 3,
                'nombre' => 'Ingeniería Eléctrica',
            ],
            [
                'id_facultad' => 3,
                'nombre' => 'Ingeniería Industrial',
            ],
            [
                'id_facultad' => 3,
                'nombre' => 'Ingeniería Mecánica',
            ],
            [
                'id_facultad' => 3,
                'nombre' => 'Ingeniería Química',
            ],
            [
                'id_facultad' => 3,
                'nombre' => 'Ingeniería de Alimentos',
            ],
            [
                'id_facultad' => 3,
                'nombre' => 'Escuela de Posgrados',
            ],
            [
                'id_facultad' => 3,
                'nombre' => 'Unidad de Ciencias Básicas',
            ],
        ];

        foreach ($escuelas as $escuela) {
            Escuela::create($escuela);
        }
    }
}
