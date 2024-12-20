<?php

namespace App\Imports;

use App\Models\Mantenimientos\Asignatura;
use Illuminate\Support\Str;
use App\Models\Mantenimientos\Aulas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AsignaturaImport implements ToModel, WithHeadingRow
{
    protected $importedData = [];

    public function model(array $row)
    {
        $this->importedData[] = $row;

        $asignatura = new Asignatura([
            'id_escuela' => $row['idescuela'],
            'nombre' => $row['codigo'],
            'nombre_completo' => $row['nombre'],
            'activo' => true,
        ]);

        $asignatura->save();

        return $asignatura;
    }

    public function getData()
    {
        return $this->importedData;
    }
}

