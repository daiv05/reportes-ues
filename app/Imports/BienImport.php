<?php

namespace App\Imports;

use App\Models\Reportes\Bien;
use App\Models\Reportes\TipoBien;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BienImport implements ToModel, WithHeadingRow
{
    protected $importedData = [];

    public function model(array $row)
    {
        $this->importedData[] = $row;

        if (!isset($row['codigo']) || !isset($row['nombre']) || !isset($row['descripcion'])) {
            return;
        } else {
            if (Bien::where('codigo', $row['codigo'])->exists()) {
                throw new \Exception('El bien ya existe con código ' . $row['codigo'] . '.');
            }
        }

        if (isset($row['idtipo'])) {
            if (!TipoBien::where('id', $row['idtipo'])->exists()) {
                throw new \Exception('El tipo de bien no existe con id ' . $row['idtipo'] . '.');
            }
        } else {
            throw new \Exception('El tipo de bien es requerido en todos los registros.');
        }

        $bien = new Bien([
            'id_tipo_bien' => $row['idtipo'],
            'id_estado_bien' => 1,
            'nombre' => $row['nombre'],
            'descripcion' => $row['descripcion'],
            'codigo' => $row['codigo'],
            'activo' => true,
        ]);

        $bien->save();

        return $bien;
    }

    public function getData()
    {
        return $this->importedData;
    }
}
