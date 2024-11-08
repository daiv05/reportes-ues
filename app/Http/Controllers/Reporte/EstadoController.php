<?php

namespace App\Http\Controllers\Reporte;

use App\Enums\EstadosEnum;
use App\Models\Reportes\Estado;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reportes\Reporte;
use Illuminate\Support\Facades\DB;

class EstadoController extends Controller
{
    public function estadosReporte(Reporte $reporte)
    {
        $estadosAllowed = [];
        $ultimoEstado = $reporte->estado_ultimo_historial?->id;
        $esSupervisor = $reporte->relacion_usuario['supervisor'];
        $esEmpleado = $reporte->relacion_usuario['empleado'];
        switch ($ultimoEstado) {
            case 1: // ASIGNADO
                $esEmpleado ? $estadosAllowed = [
                    EstadosEnum::EN_PROCESO->value,
                    EstadosEnum::EN_PAUSA->value,
                    EstadosEnum::COMPLETADO->value
                ] : null;
                break;
            case 2: // EN PROCESO
                $esEmpleado ? $estadosAllowed = [
                    EstadosEnum::EN_PAUSA->value,
                    EstadosEnum::COMPLETADO->value
                ] : null;
                break;
            case 3: // EN PAUSA
                $esEmpleado ? $estadosAllowed = [
                    EstadosEnum::EN_PROCESO->value,
                    EstadosEnum::COMPLETADO->value
                ] : null;
                break;
            case 4: // COMPLETADO
                $esSupervisor ? $estadosAllowed = [
                    EstadosEnum::FINALIZADO->value,
                    EstadosEnum::INCOMPLETO->value
                ] : null;
                break;
            case 5: // FINALIZADO
                break;
            case 6: // INCOMPLETO
                $esEmpleado ? $estadosAllowed = [
                    EstadosEnum::EN_PROCESO->value,
                    EstadosEnum::EN_PAUSA->value,
                    EstadosEnum::COMPLETADO->value
                ] : null;
                break;
            default:
                break;
        }
        $estados = DB::table('estados')->whereIn('id', $estadosAllowed)->get();
        return $estados;
    }
}
