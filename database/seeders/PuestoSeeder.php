<?php

namespace Database\Seeders;

use App\Models\rhu\Puesto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $puestos = [
            [
                'nombre' => 'PLANIFICADOR',
                'id_entidad' => 1
            ],
            [
                'nombre' => 'ASISTENTE ADMINISTRATIVO',
                'id_entidad' => 1
            ],
            [
                'nombre' => 'AUXILIAR DE PLANIFICACIÓN',
                'id_entidad' => 1
            ],
            [
                'nombre' => 'AUXILIAR TÉCNICO ADMINISTRATIVO EN INFRAESTRUCTURA',
                'id_entidad' => 1
            ],
            [
                'nombre' => 'GESTOR DE LOGÍSTICA DE EVENTOS PROTOCOLARES',
                'id_entidad' => 3
            ],
            [
                'nombre' => 'JEFE DE MANTENIMIENTO Y SERVICIOS GENERALES',
                'id_entidad' => 5
            ],
            [
                'nombre' => 'INTENDENTE',
                'id_entidad' => 4
            ],
            [
                'nombre' => 'ORDENANZA Y SERVICIOS VARIOS',
                'id_entidad' => 5
            ],
            [
                'nombre' => 'ELECTRICISTA',
                'id_entidad' => 5
            ],
            [
                'nombre' => 'CARPINTERO',
                'id_entidad' => 5
            ],
            [
                'nombre' => 'JARDINERO',
                'id_entidad' => 5
            ],
            [
                'nombre' => 'EMPLEADO CALIFICADO EN INFRAESTRUCTURA',
                'id_entidad' => 2
            ],
            [
                'nombre' => 'ENCARGADO DE TRANSPORTE Y SERVICIOS INSTITUCIONALES',
                'id_entidad' => 3
            ],
            [
                'nombre' => 'MOTORISTA',
                'id_entidad' => 3
            ]
        ];

        foreach ($puestos as $p) {
            Puesto::create($p);
        }
    }
}
