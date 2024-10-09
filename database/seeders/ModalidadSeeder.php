<?php

namespace Database\Seeders;

use App\Enums\ModalidadEnum;
use App\Models\General\Modalidad;
use Illuminate\Database\Seeder;

class ModalidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (ModalidadEnum::cases() as $modalidad) {
            Modalidad::create(['nombre' => $modalidad->value]);
        }
    }
}
