<?php

namespace App\Imports;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithstartRow;

class HorarioImport implements ToModel, WithHeadingRow
{
    protected $index = 0;
    protected $importedData = [];

    public function model(array $row)
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        // $out->writeln($row[0]);
        $modalidad = null;
        $horaInicio = null;
        $horaFin = null;
        // Extraer los horarios de cada día
        $horarios = [
            1 => $row['lunes'],
            2 => $row['martes'],
            3 => $row['miercoles'],
            4 => $row['jueves'],
            5 => $row['viernes'],
            6 => $row['sabado'],
            7 => $row['domingo'],
        ];

        // Validar que no todas las celdas estén vacías
        if (!$row['materia'] && !$row['tipo'] && !$row['modalidad'] && !$row['local'] &&
            (!$row['lunes'] || !$row['martes'] || !$row['miercoles'] || !$row['jueves'] || !$row['viernes'] || !$row['sabado'] || !$row['domingo'])) {
            return null;
        }

        if(strtolower($row['tipo']) == 'teórico' || strtolower($row['tipo']) == 'teorico' || strtolower($row['tipo']) == 'gt'){
            $row['tipo'] = 1;
        } elseif(strtolower($row['tipo']) == 'laboratorio' || strtolower($row['tipo']) == 'gl'){
            $row['tipo'] = 2;
        } elseif(strtolower($row['tipo']) == 'discusión' || strtolower($row['tipo']) == 'discusion' || strtolower($row['tipo']) == 'gd'){
            $row['tipo'] = 3;
        } else {
            $row['tipo'] = null;
        }

        // Validar y extraer horas
        foreach ($horarios as $dia => $horario) {
            if ($horario && preg_match('/^\s*(\d{2}):(\d{2})\s*-\s*(\d{2}):(\d{2})\s*$/', $horario, $matches)) {
                $horarios[$dia] = [
                    'hora_inicio' => $matches[1] . ':' . $matches[2],
                    'hora_fin' => $matches[3] . ':' . $matches[4],
                ];
                $horaInicio = $matches[1] . ':' . $matches[2];
                $horaFin = $matches[3] . ':' . $matches[4];
            } else {
                unset($horarios[$dia]);
            }
        }

        $dayKeys = array_keys($horarios);


        if(strtolower($row['modalidad']) == 'virtual' || strtolower($row['modalidad']) == 'distancia' || strtolower($row['modalidad']) == 'en línea' || strtolower($row['modalidad']) == 'en linea'){
            $modalidad = 1;
        } elseif(strtolower($row['modalidad']) == 'presencial' || !$row[2]){
            $modalidad = 2;
        }

        $this->importedData[] = [
            'index' => $this->index++,
            'materia' => $row['materia'],
            'tipo' => $row['tipo'],
            'modalidad' => $modalidad,
            'grupo' => $row['grupo'],
            'local' => $row['local'],
            'hora_inicio' => $horaInicio,
            'hora_fin' => $horaFin,
            'diasActividad' => $dayKeys,
        ];
    }

    public function getData()
    {
        return $this->importedData;
    }
}

