<?php

namespace Database\Seeders;

use App\Models\Mantenimientos\UnidadMedida;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnidadMedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unidades = [
            ['nombre' => 'Metros'],
            ['nombre' => 'Litros'],
            ['nombre' => 'Tubos'],
            ['nombre' => 'Milímetros'],
            ['nombre' => 'Onzas'],
            ['nombre' => 'Centímetros'],
            ['nombre' => 'Rollos'],
        ];

        foreach($unidades as $u) {
            UnidadMedida::create($u);
        }
    }
}
