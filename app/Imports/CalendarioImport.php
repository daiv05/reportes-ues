<?php

namespace App\Imports;

use App\Models\Mantenimientos\Asignatura;
use Illuminate\Support\Str;
use App\Models\Mantenimientos\Aulas;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNan;

class CalendarioImport implements ToModel, WithHeadingRow, WithStartRow
{
    protected $week = null;
    protected $day = null;
    protected $date = null;
    protected $index = 0;
    protected $importedData = [];

    public function startRow(): int
    {
        return 7;
    }

    public function model(array $row)
    {
        // row 0 -> Semana
        // row 1 -> Día
        // row 2 -> Fecha
        // row 3 -> Escuela
        // row 4 -> Materia
        // row 5 -> Ciclo
        // row 6 -> Evaluación
        // row 7 -> Modalidad
        // row 8 -> Cantidad de estudiantes
        // row 9 -> Comentarios
        // row 10 -> Hora de inicio
        // row 11 -> Hora de fin
        // row 12 -> Duración
        // row 13 -> Aulas
        // row 14 -> Responsable

        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $aulasCatalog = Aulas::all();
        $aulas = [];
        $modalidad = null;
        if(count($row) < 12){
            return null;
        }

        if($row[0]){
            $this->week = $row[0];
        }
        if($row[1]){
            $this->day = $row[1];
            if($row[2]){
                $this->date = $row[2];
            }
        }

        if(gettype($this->date ?? null) == 'string' || gettype($this->date ?? null) == 'NULL'){
            return null;
        }

        $this->index = $this->index + 1;

        if(isset($row[4])){
            $row[4] = substr($row[4], 0, 6);
        }

        if(strtolower($row[7]) == 'virtual' || strtolower($row[7]) == 'distancia' || strtolower($row[7]) == 'en línea' || strtolower($row[7]) == 'en linea'){
            $modalidad = 1;
        } elseif(strtolower($row[7]) == 'presencial' || !$row[7]){
            $modalidad = 2;
        }

        if($row[13]){
            $aulasExcel = explode(',', $row[13]);
            foreach($aulasExcel as $aula){
                $aula = trim($aula);
                $aula = strtoupper($aula);
                $aula = str_replace('-', '', $aula);
                $aula = str_replace(' ', '', $aula);
                if(Str::contains($aula, 'AUDITORIO') || Str::contains($aula, 'A340') || Str::contains($aula, 'MARMOL')){
                    $aula = 'AUDITORIOMARMOL';
                }
                // verifica si coincide con los nombres de las aulas en la base de datos
                foreach($aulasCatalog as $aulaCatalog){
                    if($aula == $aulaCatalog->nombre){
                        $aulas[] = $aulaCatalog->id;
                    }
                }
            }
        }

        if(!$row[4] && !$row[6] && !$row[7] && !$row[8] && !$row[10] && !$row[11]){
            $out->writeln('Fila ' . $this->index . ' ->'. $row[0] . ' ' . $row[1] . ' ' . $row[2] . ' ' . $row[3] . ' ' . $row[4] . ' ' . $row[5] . ' ' . $row[6] . ' ' . $row[7] . ' ' . $row[8] . ' ' . $row[9] . ' ' . $row[10] . ' ' . $row[11] . ' ' . $row[12]);
            return null;
        }

        $out->writeln(gettype(($row[10])) . ' - ' . gettype($row[11]));

        $this->importedData[] = [
            'index' => $this->index++,
            'semana' => $row[0] ?? $this->week,
            'fecha' => Date::excelToDateTimeObject($row[2] ?? $this->date)->format('d/m/Y'),
            'materia' => $row[4] ?? null,
            'evaluacion' => $row[6] ?? null,
            'modalidad' => $modalidad,
            'cantidad_estudiantes' => $row[8] ?? null,
            'comentarios' => $row[9] ?? null,
            'hora_inicio' => gettype($row[10]) == 'double' ? Carbon::createFromTimestamp($row[10] * 86400, 'UTC')->format('H:i') : null,
            'hora_fin' => gettype($row[11]) == 'double' ? Carbon::createFromTimestamp($row[11] * 86400, 'UTC')->format('H:i') : null,
            'aulas' => $aulas,
            'responsable' => $row[14] ?? null,
        ];
    }

    public function getData()
    {
        return $this->importedData;
    }
}

