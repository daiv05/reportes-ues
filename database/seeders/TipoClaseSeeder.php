<?php

namespace Database\Seeders;

use App\Enums\TipoClaseEnum;
use App\Models\General\TipoClase;
use Illuminate\Database\Seeder;

class TipoClaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (TipoClaseEnum::cases() as $tipoClase) {
            TipoClase::create(['nombre' => $tipoClase->value]);
        }
    }
}
