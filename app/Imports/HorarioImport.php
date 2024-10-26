<?php

namespace App\Imports;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class HorarioImport implements ToModel
{
    protected $index = 0;
    protected $importedData = [];

    public function model(array $row)
    {
        // Extraer los horarios de cada día
        $horarios = [
            'lunes' => $row[4],
            'martes' => $row[5],
            'miercoles' => $row[6],
            'jueves' => $row[7],
            'viernes' => $row[8],
            'sabado' => $row[9],
            'domingo' => $row[10],
        ];

        // Validar que no todas las celdas estén vacías
        if (!$row[0] && !$row[1] && !$row[2] && !$row[3] &&
            (!$row[4] || !$row[5] || !$row[6] || !$row[7] || !$row[8] || !$row[9] || !$row[10])) {
            return null;
        }

        // Validar y extraer horas
        foreach ($horarios as $dia => $horario) {
            if ($horario && preg_match('/^\s*(\d{2}):(\d{2})\s*-\s*(\d{2}):(\d{2})\s*$/', $horario, $matches)) {
                $horarios[$dia] = [
                    'hora_inicio' => $matches[1] . ':' . $matches[2],
                    'hora_fin' => $matches[3] . ':' . $matches[4],
                ];
            } else {
                // Formato no válido; asignar valores nulos o manejar el error
                $horarios[$dia] = [
                    'hora_inicio' => null,
                    'hora_fin' => null,
                ];
            }
        }

        $this->importedData[] = [
            'material' => $row[0],
            'tipo' => $row[1],
            'modalidad' => $row[2],
            'grupo' => $row[3],
            'horarios' => $horarios,
        ];
    }

    public function getData()
    {
        return $this->importedData;
    }
}

