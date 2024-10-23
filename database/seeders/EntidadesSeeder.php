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
                'nombre' => 'Carpinteria',
                'descripcion' => 'Descripcion'
            ],
            [
                'nombre' => 'Soporte',
                'descripcion' => 'Descripcion'
            ],
            [
                'nombre' => 'Limpieza',
                'descripcion' => 'Descripcion'
            ],
            [
                'nombre' => 'Fontaneria',
                'descripcion' => 'Descripcion'
            ],
            [
                'nombre' => 'Parqueo',
                'descripcion' => 'Descripcion'
            ],
            [
                'nombre' => 'Transporte',
                'descripcion' => 'Descripcion'
            ]
        ];

        foreach ($entidades as $entidad) {
            Entidades::create($entidad);
        }
    }
}
