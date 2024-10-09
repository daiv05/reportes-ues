<?php

namespace Database\Seeders;

use App\Models\Mantenimientos\Departamento;
use Illuminate\Database\Seeder;

class DepartamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departamentos = [
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

        foreach ($departamentos as $depa) {
            Departamento::create($depa);
        }
    }
}
