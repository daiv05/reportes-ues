<?php

namespace Database\Seeders;

use App\Models\Mantenimientos\Aulas;
use Illuminate\Database\Seeder;

class AulaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $aulas = [
            ['nombre' => 'B11', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'B21', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'B22', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'B31', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'B32', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'B33', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'B41', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'B42', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'B43', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'B44', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'B45', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'C11', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'C21', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'C22', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'C23', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'C31', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'C32', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'C41', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'C42', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'C43', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'C44', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'D11', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'D31', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'D32', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'D33', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'D41', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'D42', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'D43', 'activo' => true, 'id_facultad' => 1],
            ['nombre' => 'AUDITORIOMARMOL', 'activo' => true, 'id_facultad' => 1],
            ['nombre'=> 'LCOMP1', 'activo'=> true, 'id_facultad' => 1],
            ['nombre'=> 'LCOMP2', 'activo'=> true, 'id_facultad' => 1],
            ['nombre'=> 'LCOMP3', 'activo'=> true, 'id_facultad' => 1],
            ['nombre'=> 'LCOMP4', 'activo'=> true, 'id_facultad' => 1],
            ['nombre'=> 'LCOMP5', 'activo'=> true, 'id_facultad' => 1],
            ['nombre'=> 'LCOMP11', 'activo'=> true, 'id_facultad' => 1],
            ['nombre'=> 'BIB209', 'activo'=> true, 'id_facultad' => 1],
            ['nombre'=> 'BIB301', 'activo'=> true, 'id_facultad' => 1],
            ['nombre'=> 'BIB302', 'activo'=> true, 'id_facultad' => 1],
            ['nombre'=> 'ESPINOA', 'activo'=> true, 'id_facultad' => 1],
            ['nombre'=> 'ESPINOB', 'activo'=> true, 'id_facultad' => 1],
            ['nombre'=> 'AULACIVIL', 'activo'=> true, 'id_facultad' => 1],
            ['nombre'=> 'AULASISTEMAS', 'activo'=> true, 'id_facultad' => 1],
            ['nombre'=> 'AULAEIE', 'activo'=> true, 'id_facultad' => 1],
            ['nombre'=> 'F1', 'activo'=> true, 'id_facultad' => 1],
            ['nombre'=> 'F2', 'activo'=> true, 'id_facultad' => 1],
            ['nombre'=> 'F1312', 'activo'=> true, 'id_facultad' => 1]
        ];

        foreach ($aulas as $aula) {
            Aulas::create($aula);
        }
    }
}
