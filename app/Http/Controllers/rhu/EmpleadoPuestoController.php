<?php

namespace App\Http\Controllers\rhu;

use App\Enums\GeneralEnum;
use App\Enums\RolesEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Registro\Persona;
use App\Models\rhu\EmpleadoPuesto;
use App\Models\rhu\Entidades;
use App\Models\rhu\Puesto;
use App\Models\Seguridad\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Validator;

class EmpleadoPuestoController extends Controller
{
    public function index(Request $request): View{

        $entidadFiltro = $request->get('entidad-filtro');
        $puestoFiltro = $request->get('puesto-filtro');
        $empleadoFiltro = $request->get('empleado-filtro');

        $empleadosPuestos = EmpleadoPuesto::with('puesto.entidad', 'usuario', 'usuario.persona')
            ->when($entidadFiltro, function ($query, $entidadFiltro) {
                return $query->whereHas('puesto.entidad', function ($query) use ($entidadFiltro) {
                    $query->where('id', '=', $entidadFiltro);
                });
            })
            ->when($puestoFiltro, function ($query, $puestoFiltro) {
                return $query->where('id_puesto', '=', $puestoFiltro);
            })
            ->when($empleadoFiltro, function ($query, $empleadoFiltro) {
                return $query->whereHas('usuario.persona', function ($query) use ($empleadoFiltro) {
                    $query->whereRaw("CONCAT(nombre, ' ', apellido) LIKE ?", ["%{$empleadoFiltro}%"]);
                });
            })
            ->paginate(GeneralEnum::PAGINACION->value);
        $entidades = [];
        $entidadesBackup = \App\Models\rhu\Entidades::all();
        foreach ($entidadesBackup as $entidad) {
            $entidades[$entidad->id] = $entidad->nombre;
        }
        $puestos = Puesto::all()->groupBy('id_entidad')->map(function ($puestos) {
            return $puestos->pluck('nombre', 'id');
        });

        $empleados = User::with(('persona'))->get()->map(function ($empleado) {
            return [
                'id' => $empleado->id,
                'empleado' => $empleado->persona->nombre. ' ' . $empleado->persona->apellido,
            ];
        });

        $empleados = $empleados->pluck('empleado', 'id');

        $estados = [
            1 => 'ACTIVO',
            0 => 'INACTIVO',
        ];

        return view('rhu.empleadosPuestos.index', compact('empleadosPuestos', 'entidades', 'puestos', 'empleados', 'estados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'empleado' => 'required|exists:users,id',
            'puesto' => 'required|exists:puestos,id',
            'estado' => 'required|boolean',
        ]);

        try {
            $asignacion = EmpleadoPuesto::where('id_usuario', $request->input('empleado'))
                ->where('id_puesto', $request->input('puesto'))
                ->first();
            if ($asignacion) {
                return redirect()->route('empleadosPuestos.index')
                    ->with('message', [
                        'type' => 'warning',
                        'content' => 'El empleado ya tiene asignado el puesto seleccionado'
                    ]);
            }
            $empleadoPuesto = EmpleadoPuesto::create([
                'id_usuario' => $request->input('empleado'),
                'id_puesto' => $request->input('puesto'),
                'estado' => $request->input('estado'),
            ]);

            return redirect()->route('empleadosPuestos.index')
                ->with('message', [
                    'type' => 'success',
                    'content' => 'Asignación creado exitosamente'
                ]);
        } catch (\Exception $e) {
            return redirect()->route('empleadosPuestos.index')
                ->with('message', [
                    'type' => 'danger',
                    'content' => 'Error al crear la asignación'
                ]);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|boolean',
        ]);

        try {
            $empleadoPuesto = EmpleadoPuesto::find($id);
            $empleadoPuesto->activo = $request->input('estado');
            $empleadoPuesto->save();

            return redirect()->route('empleadosPuestos.index')
                ->with('message', [
                    'type' => 'success',
                    'content' => 'Asignación actualizado exitosamente'
                ]);
        } catch (\Exception $e) {
            return redirect()->route('empleadosPuestos.index')
                ->with('message', [
                    'type' => 'error',
                    'content' => $e->getMessage()
                ]);
        }
    }

    public function show(string $id)
    {
        $empPuesto = EmpleadoPuesto::with('puesto.entidad', 'usuario', 'usuario.persona', 'empleadosAcciones.reporte')->find($id);

        return view('rhu.empleadosPuestos.show', compact('empPuesto'));
    }

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
