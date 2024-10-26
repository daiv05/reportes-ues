<?php

namespace App\Http\Controllers\rhu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Registro\Persona;
use App\Models\rhu\EmpleadoPuesto;
use App\Models\rhu\Entidades;
use Illuminate\Support\Facades\Validator;

class EmpleadoPuestoController extends Controller
{
    public function buscarPorNombre(Request $request, $idEntidad)
    {
        try {
            // NO BORRAR xd
            // $validator = Validator::make(
            //     $request->all(),
            //     [
            //         'id_entidad' => 'integer|exists:entidades,id',
            //     ],
            //     [
            //         'id_entidad.exists' => 'La entidad específicada no existe',
            //         'id_entidad.integer' => 'El ID de la entidad debe ser de tipo entero',
            //     ]
            // );
            // if ($validator->fails()) {
            //     error_log('aaass');
            //     return response()->json([
            //         'message' => $validator->errors()->all(),
            //     ], 422);
            // }
            $entidad = Entidades::find($idEntidad);
            if (!isset($entidad)) {
                return response()->json([
                    'message' => 'Entidad no encontrada',
                ], 404);
            }
            $busqueda = $request->input('nombre_empleado');
            $empleadosPuestos = EmpleadoPuesto::whereHas('puesto.entidad', function ($query) use ($idEntidad) {
                $query->where('id', '=', $idEntidad);
            })->whereHas('usuario.persona', function ($query) use ($busqueda) {
                $query->where('nombre', 'like', "%{$busqueda}%")
                    ->orWhere('apellido', 'like', "%{$busqueda}%");
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
            return response()->json([
                'status' => 200,
                'lista_empleados' => $mappedEmpleados,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => [$e->getMessage()],
            ], 500);
        }
    }

    public function buscarSupervisorPorNombre(Request $request, $idEntidad)
    {
        try {
            $entidad = Entidades::find($idEntidad);
            if (!isset($entidad)) {
                return response()->json([
                    'message' => 'Entidad no encontrada',
                ], 404);
            }
            $busqueda = $request->input('nombre_empleado');
            $empleadosPuestos = EmpleadoPuesto::whereHas('usuario.roles', function ($query) {
                $query->where('name', 'ROLE_USUARIO_ENCARGADO_REPORTE');
            })->whereHas('puesto.entidad', function ($query) use ($idEntidad) {
                $query->where('id', '=', $idEntidad);
            })->whereHas('usuario.persona', function ($query) use ($busqueda) {
                $query->where('nombre', 'like', "%{$busqueda}%")
                    ->orWhere('apellido', 'like', "%{$busqueda}%");
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
            return response()->json([
                'status' => 200,
                'lista_empleados' => $mappedEmpleados,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => [$e->getMessage()],
            ], 500);
        }
    }
}
