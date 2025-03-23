<?php

namespace Database\Seeders;

use App\Models\Registro\Persona;
use Illuminate\Database\Seeder;

class PersonaSeeder extends Seeder
{
    public function run(): void
    {
        $personas = [
            [
                'nombre' => 'RICARDO',
                'apellido' => 'GUARDADO',
                'fecha_nacimiento' => '2000-01-01',
                'telefono' => '00000000',
            ]];

        foreach ($personas as $persona) {
            Persona::create($persona);
        }
    }
}
