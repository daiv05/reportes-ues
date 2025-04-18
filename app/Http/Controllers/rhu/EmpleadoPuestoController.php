<?php

namespace App\Http\Controllers\rhu;

use App\Enums\GeneralEnum;
use App\Enums\PermisosEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\EmpleadoImport;
use App\Models\rhu\EmpleadoPuesto;
use App\Models\rhu\Entidades;
use App\Models\rhu\Puesto;
use App\Models\Seguridad\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class EmpleadoPuestoController extends Controller
{
    public function index(Request $request): View
    {

        $entidadFiltro = $request->get('entidad-filtro');
        $puestoFiltro = $request->get('puesto-filtro');
        $empleadoFiltro = $request->get('empleado-filtro');
        $rolFilter = $request->get('role-filter');

        $empleadosPuestos = EmpleadoPuesto::with('puesto.entidad', 'usuario', 'usuario.persona','usuario.roles' )
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
            ->when($rolFilter, function ($query, $rolFilter) {
                return $query->whereHas('usuario.roles', function ($query) use ($rolFilter) {
                    $query->where('roles.id', '=', $rolFilter);
                });
            })
            ->paginate(GeneralEnum::PAGINACION->value);

        $entidades = [];
        $entidadesBackup = Entidades::where('activo', true)->get();
        foreach ($entidadesBackup as $entidad) {
            $entidades[$entidad->id] = $entidad->nombre;
        }
        $puestos = Puesto::where('activo', true)->get()->groupBy('id_entidad')->map(function ($puestos) {
            return $puestos->pluck('nombre', 'id');
        });

        $empleados = User::with(('persona'))->where('activo', true)->get()->map(function ($empleado) {
            return [
                'id' => $empleado->id,
                'empleado' => $empleado->persona->nombre . ' ' . $empleado->persona->apellido,
            ];
        });

        $roles = Role::where('activo', 1)->get();
        $roles = $roles->pluck('name', 'id');
        $empleados = $empleados->pluck('empleado', 'id');

        $estados = [
            1 => 'ACTIVO',
            0 => 'INACTIVO',
        ];

        return view('rhu.empleadosPuestos.index', compact('empleadosPuestos', 'entidades', 'puestos', 'empleados', 'estados','roles'));
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
                    'content' => 'Puesto asignado exitosamente'
                ]);
        } catch (\Exception $e) {
            return redirect()->route('empleadosPuestos.index')
                ->with('message', [
                    'type' => 'error',
                    'content' => 'Error al crear la asignación'
                ]);
        }
    }

    public function importarDatos(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv',
        ], [
            'archivo.required' => 'El archivo es obligatorio.',
            'archivo.mimes' => 'El archivo debe ser de tipo xlsx, xls o cvs.',
        ]);

        try {
            DB::beginTransaction();

            $import = new EmpleadoImport();
            Excel::import($import, $request->file('excel_file'));

            DB::commit();

            $empleados = $import->getData();

            foreach ($empleados as $empleado) {
                $usuario = $empleado['usuario'];
                $usuario->sendNewCredentials('Registro: ' .  config('app.name'), $empleado['password'], $usuario->carnet);
            }

            return redirect()->route('empleadosPuestos.index')->with('message', [
                'type' => 'success',
                'content' => 'Los empleados se han importado y se han enviado sus credenciaes exitosamente.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('empleadosPuestos.index')->with('message', [
                'type' => 'error',
                'content' => 'Ha ocurrido un error al importar los empleados: ' . $e->getMessage()
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
                    'content' => 'Asignación actualizada exitosamente'
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
            $empleadosPuestos = EmpleadoPuesto::where('activo', true)->whereHas('puesto.entidad', function ($query) use ($idEntidad) {
                $entidadesHijas = $this->obtenerEntidadesConHijos($idEntidad);
                $query->whereIn('id', array_map(function ($entidad) {
                    return $entidad->id;
                }, $entidadesHijas));
            })->whereHas('usuario', function ($query) {
                $query->where('activo', true);
            })->whereHas('usuario.roles', function ($query) {
                // Verificar que al menos un rol tenga el permiso asignado de REPORTES_ACTUALIZAR_ESTADO
                $rolesConPermiso = Role::whereHas('permissions', function ($query) {
                    $query->where('name', PermisosEnum::REPORTES_ACTUALIZAR_ESTADO->value);
                })->get()->pluck('id')->toArray();
                $query->whereIn('id', $rolesConPermiso);
            })->get();

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
            $empleadosPuestos = EmpleadoPuesto::where('activo', true)->whereHas('usuario', function ($query) {
                $query->where('activo', true);
            })->whereHas('usuario.roles', function ($query) {
                // Verificar que al menos un rol tenga el permiso asignado de REPORTES_ACTUALIZAR_ESTADO
                // y de REPORTES_REVISION_SOLUCION
                $rolesConPermiso = Role::whereHas('permissions', function ($query) {
                    $query->where('name', PermisosEnum::REPORTES_REVISION_SOLUCION->value);
                })->get()->pluck('id')->toArray();
                $query->whereIn('id', $rolesConPermiso);
            })->get();
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

    public static function obtenerEntidadesConHijos($idEntidad)
    {
        $entidadesHijas = DB::select("
            WITH RECURSIVE entidades_hijas AS (
                SELECT * FROM entidades WHERE id = ?
                UNION ALL
                SELECT e.* FROM entidades e
                INNER JOIN entidades_hijas eh ON e.id_entidad = eh.id
            )
            SELECT * FROM entidades_hijas
        ", [$idEntidad]);
        return $entidadesHijas;
    }
}
