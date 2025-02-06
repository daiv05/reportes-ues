<?php

namespace App\Imports;

use App\Models\Mantenimientos\Aulas;
use App\Models\Mantenimientos\Recurso;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AulaImport implements ToModel, WithHeadingRow
{
    protected $importedData = [];

    public function model(array $row)
    {
        $this->importedData[] = $row;

        if (!isset($row['nombre'])) {
            return;
        } else {
            if (Aulas::where('nombre', $row['nombre'])->exists()) {
                throw new \Exception('El local ya existe con nombre ' . $row['nombre'] . '.');
            }
        }

        $aulas = new Aulas([
            'nombre' => $row['nombre'],
            'id_facultad' => 1,
            'activo' => true,
        ]);

        $aulas->save();

        return $aulas;
    }

    public function getData()
    {
        return $this->importedData;
    }
}
