<?php

namespace Database\Seeders;

use App\Models\General\Sedes;
use Illuminate\Database\Seeder;

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
                'direccion' => 'San Salvador',
            ],
            [
                'nombre' => 'Sede Oriental',
                'direccion' => 'San Miguel/La Unión',
            ],
            [
                'nombre' => 'Sede de Paracentral',
                'direccion' => 'San Vicente',
            ],
            [
                'nombre' => 'Sede Occidental',
                'direccion' => 'Santa Ana',
            ],
         ];

         foreach ($sedes as $sede) {
             Sedes::create($sede);
         }
     }
}
