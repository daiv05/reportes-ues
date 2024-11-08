<?php

namespace App\Http\Controllers\Reporte;

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
                $esEmpleado ? $estadosAllowed = [2, 3, 4] : null;
                break;
            case 2: // EN PROCESO
                $esEmpleado ? $estadosAllowed = [3, 4] : null;
                break;
            case 3: // EN PAUSA
                $esEmpleado ? $estadosAllowed = [2, 4] : null;
                break;
            case 4: // COMPLETADO
                $esSupervisor ? $estadosAllowed = [5, 6] : null;
                break;
            case 5: // FINALIZADO
                break;
            case 6: // INCOMPLETO
                $esEmpleado ? $estadosAllowed = [2, 3, 4] : null;
                break;
            default:
                $estadosAllowed = [2, 3, 4];
                break;
        }
        $estados = DB::table('estados')->whereIn('id', $estadosAllowed)->get();
        return $estados;
    }
}
