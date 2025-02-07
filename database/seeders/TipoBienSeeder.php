<?php

namespace Database\Seeders;

use App\Models\Reportes\TipoBien;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoBienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipoBien = [
            ['nombre' => 'Puertas'],
            ['nombre' => 'Luminarias'],
            ['nombre' => 'Sillas'],
            ['nombre' => 'Equipos Electrónicos'],
            ['nombre' => 'Pizarras Digitales'],
            ['nombre' => 'Equipos de oficina'],
            ['nombre' => 'Baños'],
        ];

        foreach($tipoBien as $tb) {
            TipoBien::create($tb);
        }
    }
}
