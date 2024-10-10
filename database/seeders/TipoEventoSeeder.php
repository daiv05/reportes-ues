<?php

namespace Database\Seeders;

use App\Enums\TipoEventoEnum;
use App\Models\General\TipoEvento;
use Illuminate\Database\Seeder;

class TipoEventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (TipoEventoEnum::cases() as $tipoEvento) {
            TipoEvento::create(['nombre' => $tipoEvento->value]);
        }
    }
}
