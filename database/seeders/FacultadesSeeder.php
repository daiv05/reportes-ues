<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Facultades;

class FacultadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $facultades = [
            [
                'id_sedes' => 1,
                'nombre' => 'Facultad de Ciencias',
                'activo' => true
            ],
            [
                'id_sedes' => 1,
                'nombre' => 'Facultad de Artes',
                'activo' => true
            ],
            [
                'id_sedes' => 2,
                'nombre' => 'Facultad de Ingeniería',
                'activo' => false
            ],
            // Agrega más facultades según sea necesario
        ];

        foreach ($facultades as $facultad) {
            Facultades::create($facultad);
        }
    }
}
