<?php

namespace Database\Seeders;

use App\Models\Reportes\Estado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            ['nombre' => 'ASIGNADO'],
            ['nombre' => 'INICIADO'],
            ['nombre' => 'EN PROCESO'],
            ['nombre' => 'EN PAUSA'],
            ['nombre' => 'COMPLETADO'],
            ['nombre' => 'FINALIZADO']
        ];

        foreach($estados as $estado) {
            Estado::create($estado);
        }
    }
}
