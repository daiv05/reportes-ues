<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\General\TipoCiclo;
use Illuminate\Database\Seeder;

class TiposCiclosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoCiclo::insert([
            ['nombre' => 'PRIMERO', 'activo' => true],
            ['nombre' => 'SEGUNDO', 'activo' => true],
            // Agrega más tipos de ciclos según sea necesario
        ]);
    }
}
