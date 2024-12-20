<?php

namespace Database\Seeders;

use App\Models\Mantenimientos\Asignatura;
use Illuminate\Database\Seeder;

class AsignaturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $asignaturas = [
            ['id_escuela' => 3, 'nombre' => 'MTE115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'MAT115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'IAI115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'PSI115', 'activo' => 1],

            ['id_escuela' => 3, 'nombre' => 'FIR115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'MAT215', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'PRN115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'MSM115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'HSE115', 'activo' => 1],

            ['id_escuela' => 3, 'nombre' => 'FIR215', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'MAT315', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'PRN215', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'PYE115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'FDE115', 'activo' => 1],

            ['id_escuela' => 3, 'nombre' => 'FIR315', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'MAT415', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'ESD115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'PRN315', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'MEP115', 'activo' => 1],

            ['id_escuela' => 3, 'nombre' => 'SDU115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'ANS115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'HDP115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'SYP115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'MOP115', 'activo' => 1],

            ['id_escuela' => 3, 'nombre' => 'ARC115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'SIC115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'IEC115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'TSI115', 'activo' => 1],

            ['id_escuela' => 3, 'nombre' => 'MIP115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'TAD115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'DSI115', 'activo' => 1],

            ['id_escuela' => 3, 'nombre' => 'COS115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'SIO115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'ANF115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'DSI215', 'activo' => 1],

            ['id_escuela' => 3, 'nombre' => 'LPR115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'RHU115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'BAD115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'SGI115', 'activo' => 1],

            ['id_escuela' => 3, 'nombre' => 'CPR115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'ACC115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'API115', 'activo' => 1],

            ['id_escuela' => 3, 'nombre' => 'TPI115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'TDS115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'SIF115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'IGF115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'TOO115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'COS215', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'CET115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'IBD115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'PDM115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'EBB115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'AUS115', 'activo' => 1],
            ['id_escuela' => 3, 'nombre' => 'SGG115', 'activo' => 1],
        ];

        foreach ($asignaturas as $asignatura) {
            Asignatura::create($asignatura);
        }
    }
}
