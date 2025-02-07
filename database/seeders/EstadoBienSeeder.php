<?php

namespace Database\Seeders;

use App\Models\General\EstadoBien;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoBienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            [
                'nombre' => 'ACTIVO',
                'descripcion' => 'Indica que el bien se encuentra en uso',
                'activo' => '1',
            ],
            [
                'nombre' => 'INACTIVO',
                'descripcion' => 'Indica que el bien se encuentra fuera de uso',
                'activo' => '1',
            ],
            [
                'nombre' => 'DESCARGO',
                'descripcion' => 'Indica que el bien ha sido dado de baja',
                'activo' => '1',
            ],

        ];

        foreach($estados as $estado) {
            EstadoBien::create($estado);
        }
    }
}
