<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sedes;

class SedesSeeder extends Seeder
{
     /**
     * Run the database seeds.
     */

     public function run(): void
     {
         $sedes = [
            [
                'nombre' => 'Sede Central',
                'direccion' => 'Departamento de San Salvador',
            ],
            [
                'nombre' => 'Sede Oriental',
                'direccion' => 'Departamento de San Miguel/La Unión',
            ],
            [
                'nombre' => 'Sede de Paracentral',
                'direccion' => 'Departamento de San Vicente',
            ],
            [
                'nombre' => 'Sede Occidental',
                'direccion' => 'Departamento de Santa Ana',
            ],
         ];

         foreach ($sedes as $sede) {
             Sedes::create($sede);
         }
     }
}
