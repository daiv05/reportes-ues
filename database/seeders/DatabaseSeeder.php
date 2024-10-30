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
        $this->call(EntidadesSeeder::class);
        $this->call(PuestoSeeder::class);
        $this->call(RolSeeder::class);
        $this->call(PersonaSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UsuarioRolSeeder::class);
        $this->call(ModalidadSeeder::class);
        $this->call(TipoClaseSeeder::class);
        $this->call(DiaSeeder::class);
        $this->call(TipoEventoSeeder::class);
        $this->call(SedesSeeder::class);
        $this->call(FacultadesSeeder::class);
        $this->call(EscuelaSeeder::class);
        $this->call(AulaSeeder::class);
        $this->call(AsignaturaSeeder::class);
        $this->call(ReporteSeeder::class);
        $this->call(EstadoSeeder::class);
        $this->call(EmpleadoPuestoSeeder::class);
    }

}
