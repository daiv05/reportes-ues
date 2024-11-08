<?php

namespace App\Http\Controllers\rhu;

use App\Enums\RolesEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Registro\Persona;
use App\Models\rhu\EmpleadoPuesto;
use App\Models\rhu\Entidades;
use Illuminate\Support\Facades\Validator;

class EmpleadoPuestoController extends Controller
{
    public function listadoEmpleadosPorUnidad($idEntidad)
    {
        try {
            $entidad = Entidades::find($idEntidad);
            if (!isset($entidad)) {
                return [];
            }
            $empleadosPuestos = EmpleadoPuesto::whereHas('puesto.entidad', function ($query) use ($idEntidad) {
                $query->where('id', '=', $idEntidad);
            })->with('puesto', 'usuario', 'usuario.persona')->get();

            $mappedEmpleados = collect($empleadosPuestos)->map(function ($empleado) {
                return [
                    'id_empleado_puesto' => $empleado['id'],
                    'id_usuario' => $empleado['id_usuario'],
                    'id_puesto' => $empleado['id_puesto'],
                    'carnet' => $empleado['usuario']['carnet'],
                    'email' => $empleado['usuario']['email'],
                    'nombre_puesto' => $empleado['puesto']['nombre'],
                    'nombre_empleado' => $empleado['usuario']['persona']['nombre'],
                    'apellido_empleado' => $empleado['usuario']['persona']['apellido'],
                ];
            })->toArray();
            return $mappedEmpleados;
        } catch (\Exception $e) {
            return [];
        }
    }

    public function listadoSupervisores()
    {
        try {
            $empleadosPuestos = EmpleadoPuesto::whereHas('usuario.roles', function ($query) {
                $query->where('name', RolesEnum::SUPERVISOR_REPORTE->value);
            })->with('puesto', 'usuario', 'usuario.persona')->get();
            $mappedEmpleados = collect($empleadosPuestos)->map(function ($empleado) {
                return [
                    'id_empleado_puesto' => $empleado['id'],
                    'id_usuario' => $empleado['id_usuario'],
                    'id_puesto' => $empleado['id_puesto'],
                    'carnet' => $empleado['usuario']['carnet'],
                    'email' => $empleado['usuario']['email'],
                    'nombre_puesto' => $empleado['puesto']['nombre'],
                    'nombre_empleado' => $empleado['usuario']['persona']['nombre'],
                    'apellido_empleado' => $empleado['usuario']['persona']['apellido'],
                ];
            })->toArray();
            return $mappedEmpleados;
        } catch (\Exception $e) {
            return [];
        }
    }
}
