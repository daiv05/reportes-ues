<?php

namespace Database\Seeders;

use App\Models\Mantenimientos\CategoriaReporte;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaReporteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            [
                'nombre' => 'Muy Baja (Rutina)',
                'descripcion' => 'Limpieza de basura',
                'tiempo_promedio' => '30',
                'unidad_tiempo' => 'minutos',
            ],
            [
                'nombre' => 'Baja (Simple)',
                'descripcion' => 'Cambios de focos, revisiones de software',
                'tiempo_promedio' => '60',
                'unidad_tiempo' => 'minutos',
            ],
            [
                'nombre' => 'Media (Estándar)',
                'descripcion' => 'Reparación de muebles, mantenimientos eléctricos menores',
                'tiempo_promedio' => '180',
                'unidad_tiempo' => 'minutos',
            ],
            [
                'nombre' => 'Alta (Compleja)',
                'descripcion' => 'Reparación de tuberías, mantenimiento de aires acondicionados',
                'tiempo_promedio' => '480',
            ],
            [
                'nombre' => 'Muy Alta (Crítica)',
                'descripcion' => 'Remodelaciones, reparaciones de emergencia',
                'tiempo_promedio' => '7200',
            ],
            [
                'nombre' => 'Prolongada (Larga duración)',
                'descripcion' => 'Construcción, proyectos estructurales',
                'tiempo_promedio' => '86400',
            ],
            [
                'nombre' => 'Extensiva (Muy larga duración)',
                'descripcion' => 'Obras grandes, implementación de sistemas completos',
                'tiempo_promedio' => '130000',
            ]
        ];

        foreach ($categorias as $categoria) {
            CategoriaReporte::create($categoria);
        }
    }
}
