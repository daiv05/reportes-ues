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
                 'nombre' => 'Sede Centro',
                 'direccion' => 'Calle Principal 123',
                 'activo' => true,
             ],
             [
                 'nombre' => 'Sede Norte',
                 'direccion' => 'Avenida Norte 456',
                 'activo' => true,
             ],
             [
                 'nombre' => 'Sede Sur',
                 'direccion' => 'Calle Sur 789',
                 'activo' => true,
             ],
         ];

         foreach ($sedes as $sede) {
             Sedes::create($sede);
         }
     }
}
