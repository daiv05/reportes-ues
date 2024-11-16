<?php

namespace Database\Seeders;

use App\Models\Mantenimientos\Fondo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FondoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fondos = [
            ['nombre' => 'Fondo circulante'],
            ['nombre' => 'Fondo de emergencia'],
        ];

        foreach($fondos as $f) {
            Fondo::create($f);
        }
    }
}
