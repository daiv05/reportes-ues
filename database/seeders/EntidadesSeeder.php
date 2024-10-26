<?php

namespace Database\Seeders;

use App\Models\rhu\Entidades;
use Illuminate\Database\Seeder;

class EntidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entidades = [
            [
                'nombre' => 'UNIDAD DE PLANIFICACION',
                'descripcion' => 'Descripcion'
            ],
            [
                'nombre' => 'DESARROLLO E INFRAESTRUCTURA',
                'descripcion' => 'Descripcion'
            ],
            [
                'nombre' => 'LOGISTICA Y GESTION',
                'descripcion' => 'Descripcion'
            ],
            [
                'nombre' => 'REGISTRO Y ESTADISTICAS',
                'descripcion' => 'Descripcion'
            ],
            [
                'nombre' => 'MANTENIMIENTO Y SERVICIOS GENERALES',
                'descripcion' => 'Descripcion'
            ],
            [
                'nombre' => 'ESCUELA DE INGENIERIA DE SISTEMAS INFORMATICOS',
                'descripcion' => 'Descripcion'
            ],
            [
                'nombre' => 'ESCUELA DE ARQUITECTURA',
                'descripcion' => 'Descripcion'
            ],
            [
                'nombre' => 'ESCUELA DE INGENIERIA INDUSTRIAL',
                'descripcion' => 'Descripcion'
            ],
            [
                'nombre' => 'ESCUELA DE INGENIERIA CIVIL',
                'descripcion' => 'Descripcion'
            ]
        ];

        foreach ($entidades as $entidad) {
            Entidades::create($entidad);
        }
    }
}
