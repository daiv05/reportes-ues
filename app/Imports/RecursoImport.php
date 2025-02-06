<?php

namespace App\Imports;

use App\Models\Mantenimientos\Recurso;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RecursoImport implements ToModel, WithHeadingRow
{
    protected $importedData = [];

    public function model(array $row)
    {
        $this->importedData[] = $row;

        if (!isset($row['nombre'])) {
            return;
        } else {
            if (Recurso::where('nombre', $row['nombre'])->exists()) {
                throw new \Exception('El recurso ya existe con nombre ' . $row['nombre'] . '.');
            }
        }

        $recurso = new Recurso([
            'nombre' => $row['nombre'],
            'activo' => true,
        ]);

        $recurso->save();

        return $recurso;
    }

    public function getData()
    {
        return $this->importedData;
    }
}
