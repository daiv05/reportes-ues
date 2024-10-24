<?php

namespace App\Http\Controllers\Reporte;

use App\Enums\TipoReporteEnum;
use App\Http\Controllers\Controller;
use App\Models\Actividades\Actividad;
use App\Models\Reportes\AccionesReporte;
use App\Models\rhu\Entidades;
use App\Models\Reportes\Reporte;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ReporteController extends Controller
{

    public function index()
    {
        $reportes = Reporte::with('aula', 'actividad', 'accionesReporte', 'accionesReporte.entidadAsignada', 'usuarioReporta', 'usuarioReporta.persona', 'empleadosAcciones')->paginate(10);
        return response()->json([
            'status' => 200,
            'data' => $reportes
        ], 200);
        // return view('reportes.index', compact('reportes'));
    }

    public function create(Request $request): View
    {
        $validated = $request->validate(
            [
                'actividad' => 'integer|exists:actividades,id',
            ],
            [
                'actividad.exists' => 'La actividad seleccionada no existe'
            ]
        );
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
                'descripcion' => 'required|string',
                'titulo' => 'required|string|max:50',
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
        $reporte = Reporte::find($id_reporte)->with('aula', 'actividad', 'accionesReporte', 'accionesReporte.entidadAsignada', 'accionesReporte.usuarioSupervisor', 'usuarioReporta', 'usuarioReporta.persona', 'empleadosAcciones');
        if (isset($reporte)) {
            $entidades = Entidades::all();
            return view('reportes.detail', compact('reporte', 'entidades'));
        } else {
            return redirect()->route('reportes.index')->with('message', [
                'type' => 'error',
                'content' => 'El reporte especificado no existe'
            ]);
        }
    }

    public function marcarNoProcede(Request $request, $id_reporte)
    {
        $reporte = Reporte::find($id_reporte);
        if (isset($reporte)) {
            $reporte->no_procede = !$reporte->no_procede;
            $reporte->save();
            return response()->json([
                'message' => 'Reporte actualizado',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Reporte no encontrado',
            ], 404);
        }
    }

    public function actualizarEntidadAsignada(Request $request, $id_reporte)
    {
        $validated = $request->validate(
            ['id_entidad' => 'integer|exists:entidades,id'],
            ['id_entidad.exists' => 'La entidad seleccionada no existe']
        );
        $reporte = Reporte::find($id_reporte);
        if (isset($reporte)) {
            $accionesReporte = AccionesReporte::where('id_reporte', $id_reporte)->first();
            if (isset($accionesReporte)) {
                $accionesReporte->id_entidad_asignada = $validated['id_entidad'];
                $accionesReporte->save();
            } else {
                $newAccionesReporte = new AccionesReporte;
                $newAccionesReporte->id_reporte = $id_reporte;
                $newAccionesReporte->id_usuario_administracion = Auth::user()->id;
                $newAccionesReporte->id_entidad_asignada = $validated['id_entidad'];
                $newAccionesReporte->id_reporte = $id_reporte;
                $newAccionesReporte->save();
            }
            return response()->json([
                'message' => 'Reporte actualizado',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Reporte no encontrado',
            ], 404);
        }
    }
}
