<?php

namespace App\Http\Controllers\Reporte;

use App\Enums\TipoReporteEnum;
use App\Http\Controllers\Controller;
use App\Models\Actividades\Actividad;
use App\Models\rhu\Entidades;
use App\Models\Reportes\Reporte;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $query = Reporte::query();

        // Filtro por fecha
        if ($request->has('filter-radio')) {
            $filtro = $request->input('filter-radio');

            switch ($filtro) {
                case 'hoy':
                    $query->whereDate('fecha_reporte', today());
                    break;
                case '7_dias':
                    $query->where('fecha_reporte', '>=', now()->subDays(7));
                    break;
                case '30_dias':
                    $query->where('fecha_reporte', '>=', now()->subDays(30));
                    break;
                case 'mes':
                    $query->where('fecha_reporte', '>=', now()->subMonth());
                    break;
                case 'anio':
                    $query->where('fecha_reporte', '>=', now()->subYear());
                    break;
            }
        }

        // Filtro por título (búsqueda por nombre)
        if ($request->has('titulo')) {
            $titulo = $request->input('titulo');
            $query->where('titulo', 'like', '%' . $titulo . '%');
        }

        $reportes = $query->paginate(10);
        return view('reportes.index', compact('reportes'));
    }

    public function create(Request $request): View
    {
        $idActividad = $request->query('actividad');
        $actividad = null;
        if ($idActividad) {
            $actividad = Actividad::findOrFail($idActividad);
        }
        return view('reportes.create', compact('actividad'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'id_aula' => 'integer|exists:aulas,id',
                'id_actividad' => 'integer|exists:actividades,id',
                'tipoReporte' => [Rule::enum(TipoReporteEnum::class)],
                // 'id_usuario_reporta',
                // 'fecha_reporte',
                // 'hora_reporte',
                'descripcion' => 'required|string',
                'titulo' => 'required|string|max:50',
                // 'no_procede'
            ],
            [
                'id_aula.exists' => 'El aula no existe',
                'id_actividad.exists' => 'La actividad no existe',
                'descripcion.required' => 'Debe ingresar la descripción del reporte',
                'titulo.required' => 'Debe ingresar el titulo del reporte',
            ]
        );
        $reporte = new Reporte();
        $errors = Validator::make([], []);
        if ($request->tipoReporte == 'actividad') {
            if (isset($request->id_actividad)) {
                $reporte->id_actividad = $validated['id_actividad'];
            } else {
                $errors->getMessageBag()->add('id_actividad', 'Debe especificar una actividad');
                throw new ValidationException($errors);
            }
        }
        // He pensado en guardar aqui las aulas relacionadas a la actividad, pero por ahora no xd
        $reporte->id_usuario_reporta = Auth::user()->id;
        $reporte->fecha_reporte = Carbon::now()->format('Y-m-d');
        $reporte->hora_reporte = Carbon::now()->format('H:i:s');
        $reporte->titulo = $validated['titulo'];
        $reporte->descripcion = $validated['descripcion'];
        $reporte->save();

        return redirect()->route('reportes.index')->with('message', [
            'type' => 'success',
            'content' => 'Reporte enviado exitosamente.'
        ]);
    }

    public function detalle(Request $request, $id_reporte)
    {
        $reporte = Reporte::findOrFail($id_reporte)->with('aula', 'actividad', 'accionesReporte', 'accionesReporte.entidadAsignada', 'accionesReporte.usuarioSupervisor', 'usuarioReporta', 'empleadosAcciones');
        $entidades = Entidades::all();
        return view('reportes.detail', compact('reporte', 'entidades'));
    }
}
