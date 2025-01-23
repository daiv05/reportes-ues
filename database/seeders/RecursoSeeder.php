<?php

namespace Database\Seeders;

use App\Models\Mantenimientos\Recurso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recursos = [
            ['nombre' => 'madera de pino'],
            ['nombre' => 'plywood'],
            ['nombre' => 'melamina'],
            ['nombre' => 'formica'],
            ['nombre' => 'cuartón'],
            ['nombre' => 'tablas'],
            ['nombre' => 'clavos'],
            ['nombre' => 'tornillos'],
            ['nombre' => 'manijas'],
            ['nombre' => 'anclas'],
            ['nombre' => 'pernos'],
            ['nombre' => 'arandelas'],
            ['nombre' => 'tuercas'],
            ['nombre' => 'pegamento'],
            ['nombre' => 'barniz'],
            ['nombre' => 'pintura para madera'],
            ['nombre' => 'Válvulas de paso libre'],
            ['nombre' => 'Válvulas flangeadas'],
            ['nombre' => 'Válvulas de globo'],
            ['nombre' => 'Válvulas de bola'],
            ['nombre' => 'Válvulas tipo mariposa'],
            ['nombre' => 'Válvulas check horizontal'],
            ['nombre' => 'Válvulas check vertical'],
            ['nombre' => 'Válvulas check swing'],
            ['nombre' => 'cemento blanco'],
            ['nombre' => 'Gas refrigerante 410A'],
            ['nombre' => 'cobre'],
            ['nombre' => 'estaño'],
            ['nombre' => 'hierro'],
            ['nombre' => 'tubo pvc'],
            ['nombre' => 'tubo de cobre'],
            ['nombre' => 'tubo de aluminio'],
            ['nombre' => 'tubo de acero'],
            ['nombre' => 'tubo de acero inoxidable'],
            ['nombre' => 'tubo de acero galvanizado'],
            ['nombre' => 'desinfectante'],
            ['nombre' => 'lejía'],
            ['nombre' => 'gasolina'],
        ];

        foreach($recursos as $r) {
            Recurso::firstOrCreate($r);
        }
    }
}
