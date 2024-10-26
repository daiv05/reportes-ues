<?php

namespace App\Imports;

use App\Models\Calendario;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CalendarioImport implements ToModel
{
    protected $week = null;
    protected $day = null;
    protected $date = null;
    protected $index = 0;
    protected $importedData = [];

    public function model(array $row)
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $horario = $row[11] ?? null;

        if($row[0]){
            $this->week = $row[0];
        }
        if($row[1]){
            $this->day = $row[1];
            if($row[2]){
                $this->date = $row[2];
            }
        }

        if(gettype($row[2] ?? null) == 'string' || gettype($row[2] ?? null) == 'NULL'){
            return null;
        }

        $this->index = $this->index + 1;

        if(isset($row[11])){
            $horario = $row[11];
            $horario = array_map('trim', explode('-', $horario));
        }

        if(isset($row[4])){
            $row[4] = substr($row[4], 0, 6);
        }


        if(!$row[12]){
            $row[12] = 'No se requiere aula';
        }


        if(!$row[4] && !$row[5] && !$row[6] && !$row[7] && !$row[8] && !$row[9] && !$row[10] && !$row[11]){
            return null;
        }

        // return new Calendario([
        //     'semana'        => $this->week, // Asegúrate de que el encabezado coincida con el Excel
        //     'dia'           => $this->day, // Asegúrate de que el encabezado coincida con el Excel
        //     'fecha'         => Date::excelToDateTimeObject($this->date),
        //     'escuela'       => $row[3] ?? null,
        //     'codigo'        => $row[4] ?? null,
        //     'ciclo'         => $row[5] ?? null,
        //     'evaluacion'    => $row[6] ?? null,
        //     'modalidad'     => $row[7] ?? null,
        //     'cantidad_estudiantes' => $row[8] ?? null,
        //     'comentarios'   => $row[9] ?? null,
        //     'duracion'      => $row[10] ?? null,
        //     'horario'       => $row[11] ?? null,
        //     'local'         => $row[12] ?? null,
        // ]);
        $this->importedData[] = [
            'semana' => $row[0] ?? $this->week,
            'fecha' => Date::excelToDateTimeObject($row[2] ?? $this->date)->format('d/m/Y'),
            'codigo' => $row[4] ?? null,
            'evaluacion' => $row[6] ?? null,
            'modalidad' => $row[7] ?? null,
            'cantidad_estudiantes' => $row[8] ?? null,
            'comentarios' => $row[9] ?? null,
            'duracion' => $row[10] ?? null,
            'horario' => $row[11] ?? null,
            'hora_inicio' => $horario[0] ?? null,
            'hora_fin' => $horario[1] ?? null,
            'local' => $row[12] ?? 'No se requiere aula',
        ];
    }

    public function getData()
    {
        return $this->importedData;
    }
}

