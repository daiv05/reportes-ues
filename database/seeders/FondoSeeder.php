<?php

namespace Database\Seeders;

use App\Models\Mantenimientos\Fondo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FondoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fondos = [
            [
                'nombre' => 'Fondo circulante',
                'descripcion' => 'El recurso proviene de bodega'
            ],
            [
                'nombre' => 'Fondo de emergencia',
                'descripcion' => 'El recurso no fue encontrado en bodega y tuvo que comprarse'
            ],
        ];

        foreach($fondos as $f) {
            Fondo::create($f);
        }
    }
}
