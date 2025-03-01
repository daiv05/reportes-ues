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
                'descripcion' => 'Cambios de focos, revisiones',
                'tiempo_promedio' => '60',
                'unidad_tiempo' => 'minutos',
            ],
            [
                'nombre' => 'Media (Estándar)',
                'descripcion' => 'Reparación de muebles',
                'tiempo_promedio' => '180',
                'unidad_tiempo' => 'minutos',
            ],
        ];

        foreach ($categorias as $categoria) {
            CategoriaReporte::create($categoria);
        }
    }
}
