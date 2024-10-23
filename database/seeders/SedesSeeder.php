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
                'direccion' => 'Entidadesa de San Salvador',
            ],
            [
                'nombre' => 'Sede Oriental',
                'direccion' => 'Entidadesa de San Miguel/La Unión',
            ],
            [
                'nombre' => 'Sede de Paracentral',
                'direccion' => 'Entidadesa de San Vicente',
            ],
            [
                'nombre' => 'Sede Occidental',
                'direccion' => 'Entidadesa de Santa Ana',
            ],
         ];

         foreach ($sedes as $sede) {
             Sedes::create($sede);
         }
     }
}
