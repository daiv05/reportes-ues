<?php

namespace Database\Seeders;

use App\Models\Persona;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonaSeeder extends Seeder
{
    public function run(): void
    {
        $personas = [
            [
                'nombre' => 'Superadmin',
                'apellido' => '-',
                'fecha_nacimiento' => '2001-08-04',
                'telefono' => '74641460',
            ],
            [
                'nombre' => 'Encargado Reporte 1',
                'apellido' => '-',
                'fecha_nacimiento' => '2001-08-04',
                'telefono' => '74641460',
            ],
            [
                'nombre' => 'Encargado Reporte 2',
                'apellido' => '-',
                'fecha_nacimiento' => '2003-11-01',
                'telefono' => '74641460',
            ],
            [
                'nombre' => 'Encargado Departamento 1',
                'apellido' => '-',
                'fecha_nacimiento' => '2002-02-11',
                'telefono' => '74641460',
            ],
            [
                'nombre' => 'Encargado Departamento 2',
                'apellido' => '-',
                'fecha_nacimiento' => '2002-10-14',
                'telefono' => '74641460',
            ],
            [
                'nombre' => 'Empleado 1',
                'apellido' => '-',
                'fecha_nacimiento' => '2002-02-11',
                'telefono' => '74641460',
            ],
            [
                'nombre' => 'Empleado 2',
                'apellido' => '-',
                'fecha_nacimiento' => '2002-10-14',
                'telefono' => '74641460',
            ],
            [
                'nombre' => 'Empleado 3',
                'apellido' => '-',
                'fecha_nacimiento' => '2002-02-11',
                'telefono' => '74641460',
            ],
            [
                'nombre' => 'Empleado 4',
                'apellido' => '-',
                'fecha_nacimiento' => '2002-10-14',
                'telefono' => '74641460',
            ],
            [
                'nombre' => 'Usuario 1',
                'apellido' => '-',
                'fecha_nacimiento' => '2002-02-11',
                'telefono' => '74641460',
            ],
            [
                'nombre' => 'Usuario 2',
                'apellido' => '-',
                'fecha_nacimiento' => '2002-10-14',
                'telefono' => '74641460',
            ],
            [
                'nombre' => 'Usuario 3',
                'apellido' => '-',
                'fecha_nacimiento' => '2002-02-11',
                'telefono' => '74641460',
            ],
            [
                'nombre' => 'Usuario 4',
                'apellido' => '-',
                'fecha_nacimiento' => '2002-10-14',
                'telefono' => '74641460',
            ]
        ];

        foreach ($personas as $persona) {
            Persona::create($persona);
        }
    }
}
