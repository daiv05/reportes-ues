<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Enums\RolesEnum;
use Spatie\Permission\Models\Role;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        foreach (RolesEnum::cases() as $rol) {
            Role::create(['name' => $rol->value]);
        }
    }
}
