<?php

namespace Database\Seeders;

use App\Enums\DiasEnum;
use App\Models\General\Dia;
use Illuminate\Database\Seeder;

class DiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(DiasEnum::cases() as $dia) {
            Dia::create(['nombre' => $dia->value]);
        }
    }
}
