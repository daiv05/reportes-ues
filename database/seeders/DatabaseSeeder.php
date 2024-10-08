<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(DepartamentosSeeder::class);
        $this->call(RolSeeder::class);
        $this->call(PersonaSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UsuarioRolSeeder::class);
        $this->call(SedesSeeder::class);
        $this->call(FacultadesSeeder::class);
    }

}
