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
                'nombre' => 'Escuela de Ingeniería Civil',
            ],
            [
                'id_facultad' => 3,
                'nombre' => 'Escuela Ingeniería de Sistemas Informáticos',
            ],
            [
                'id_facultad' => 3,
                'nombre' => 'Escuela de Ingeniería Eléctrica',
            ],
            [
                'id_facultad' => 3,
                'nombre' => 'Escuela Ingeniería Industrial',
            ],
            [
                'id_facultad' => 3,
                'nombre' => 'Escuela de Ingeniería Mecánica',
            ],
            [
                'id_facultad' => 3,
                'nombre' => 'Escuela Ingeniería Química e Ingeniería de Alimentos',
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
