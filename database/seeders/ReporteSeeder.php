<?php

namespace Database\Seeders;

use App\Models\Reportes\Reporte;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReporteSeeder extends Seeder
{
    public function run(): void
    {
        $reportes = [
            [
                'id_aula' => null,
                'id_actividad' => null,
                'id_usuario_reporta' => 3,
                'fecha_reporte' => '2024/10/23',
                'hora_reporte' => '10:20:00',
                'descripcion' => 'Basura tirada ...',
                'titulo'=> 'Basura',
                'no_procede' => false
            ],
            [
                'id_aula' => null,
                'id_actividad' => null,
                'id_usuario_reporta' => 3,
                'fecha_reporte' => '2024/10/24',
                'hora_reporte' => '12:30:00',
                'descripcion' => 'Hola tirada ...',
                'titulo'=> 'Hola',
                'no_procede' => false
            ],
            [
                'id_aula' => null,
                'id_actividad' => null,
                'id_usuario_reporta' => 3,
                'fecha_reporte' => '2024/10/25',
                'hora_reporte' => '08:00:00',
                'descripcion' => 'Derrumbre tirada ...',
                'titulo'=> 'Derrumbre',
                'no_procede' => false
            ],
        ];

        foreach ($reportes as $reportes) {
            Reporte::create($reportes);
        }
    }
}