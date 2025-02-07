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
            [
                'nombre' => 'ASIGNADO',
                'descripcion' => 'Reporte asignado para su solución'
            ],
            [  
                'nombre' => 'EN PROCESO',
                'descripcion' => 'Se ha realizado un nuevo avance en la solución del reporte'
            ],
            [
                'nombre' => 'EN PAUSA',
                'descripcion' => 'Se ha detenido la solución del reporte temporalmente'
            ],
            [
                'nombre' => 'COMPLETADO',
                'descripcion' => 'Se ha completado la solución del reporte'
            ],
            [
                'nombre' => 'FINALIZADO',
                'descripcion' => 'Se ha verificado y se da por finalizado la solución del reporte'
            ],
            [
                'nombre' => 'INCOMPLETO',
                'descripcion' => 'Se han encontrado problemas en la solución del reporte'
            ]
        ];

        foreach($estados as $estado) {
            Estado::create($estado);
        }
    }
}
