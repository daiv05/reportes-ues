<?php

namespace App\Http\Controllers\Reporte;

use App\Http\Controllers\Controller;
use App\Models\Reportes\Reporte;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReporteController extends Controller
{

    public function index(): View
    {
        $reportes = Reporte::with('aula', 'actividad', 'accionesReporte', 'empleadosAcciones');
        $reportes = $reportes->paginate(10);
        return view('reportes.index', compact('reportes'));
    }

    public function create(Request $request): View
    {
        $idActividad = $request->query('actividad');
        $tipoActividad = $request->query('tipoActividad');
        return view('reportes.create', compact('reportes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'id_aula' => 'integer|exists:aulas,id',
                'id_actividad' => 'integer|exists:actividades,id',
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
                'descripcion.required' => 'Debe ingresar una descripción del reporte',
                'titulo.required' => 'Debe ingresar el titulo del reporte',
            ]
        );

        $reporte = new Reporte();
        if ($request->query('tipoActividad')) {
            $reporte->id_actividad = $validated['id_actividad'];
        }
        $reporte->id_usuario_reporta = Auth::user()->id;
        $reporte->fecha_reporte = Carbon::now()->format('YYYY-MM-DD');
        $reporte->hora_reporte = Carbon::now()->format('hh:mm');
        $reporte->titulo = $validated['titulo'];
        $reporte->descripcion = $validated['descripcion'];
        $reporte->save();

        return redirect()->route('reportes.index')->with('message', [
            'type' => 'success',
            'content' => 'Reporte enviado exitosamente.'
        ]);
    }

    public function detalle()
    {
        return view('reportes.detail');
    }
}
