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
                'nombre' => 'Bodega',
                'descripcion' => 'El recurso proviene de bodega'
            ],
            [
                'nombre' => 'Fondo circulante',
                'descripcion' => 'El recurso no fue encontrado en bodega y tuvo que comprarse'
            ],
            [
                'nombre' => 'Material reciclado',
                'descripcion' => 'El recurso proviene de material reciclado'
            ],
        ];

        foreach($fondos as $f) {
            Fondo::create($f);
        }
    }
}
