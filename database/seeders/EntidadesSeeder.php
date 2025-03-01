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
                'descripcion' => 'Descripcion',
                'id_entidad' => 1,
                'jerarquia' => 1
            ],
            [
                'nombre' => 'LOGISTICA Y GESTION',
                'descripcion' => 'Descripcion',
                'id_entidad' => 1,
                'jerarquia' => 1
            ],
            [
                'nombre' => 'REGISTRO Y ESTADISTICAS',
                'descripcion' => 'Descripcion',
                'id_entidad' => 1,
                'jerarquia' => 1
            ],
            [
                'nombre' => 'MANTENIMIENTO Y SERVICIOS GENERALES',
                'descripcion' => 'Descripcion',
                'id_entidad' => 1,
                'jerarquia' => 1
            ]
        ];

        foreach ($entidades as $entidad) {
            Entidades::create($entidad);
        }
    }
}
