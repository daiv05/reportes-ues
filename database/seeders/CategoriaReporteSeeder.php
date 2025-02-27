<?php

namespace Database\Seeders;

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
                'icono' => 'fas fa-trash',
                'tiempo_promedio' => '30',
                'peso' => 0.8
            ],
            [
                'nombre' => 'Baja (Simple)',
                'descripcion' => 'Cambios de focos, revisiones',
                'icono' => 'fas fa-toilet',
                'tiempo_promedio' => '60',
                'peso' => 1
            ],
            [
                'nombre' => 'Media (Estándar)',
                'descripcion' => 'Reparación de muebles',
                'icono' => 'fas fa-fan',
                'tiempo_promedio' => '180',
                'peso' => 1.5
            ],
        ];

        foreach ($categorias as $categoria) {
            \App\Models\CategoriaReporte::create($categoria);
        }
    }
}
