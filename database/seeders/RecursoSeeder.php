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
            ['nombre' => 'Cinta Aislante'],
            ['nombre' => 'Tubo PVC'],
            ['nombre' => 'Losa de piedra'],
            ['nombre' => 'Cola'],
        ];

        foreach($recursos as $r) {
            Recurso::create($r);
        }
    }
}
