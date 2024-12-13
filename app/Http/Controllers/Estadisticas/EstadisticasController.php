<?php

namespace App\Http\Controllers\Estadisticas;
use App\Http\Controllers\Controller;
use App\Models\Reportes\Estado;
use App\Models\Reportes\Reporte;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Http\Request;

class EstadisticasController extends Controller
{
    public function index(Request $request)
    {
        $estados = Estado::orderBy('id')->pluck('nombre');
        $estados->push('NO ASIGNADO');
        $estados->push('NO PROCEDE');

        $reportesNoProcede = Reporte::where('no_procede', true)->count();
        $reportes = Reporte::where('no_procede', false);

        if ($request->has('filter-radio')) {
            $filtro = $request->input('filter-radio');

            switch ($filtro) {
                case 'hoy':
                    $reportes->whereDate('fecha_reporte', today());
                    break;
                case '7_dias':
                    $reportes->where('fecha_reporte', '>=', now()->subDays(7));
                    break;
                case '30_dias':
                    $reportes->where('fecha_reporte', '>=', now()->subDays(30));
                    break;
                case 'mes':
                    $reportes->where('fecha_reporte', '>=', now()->subMonth());
                    break;
                case 'anio':
                    $reportes->where('fecha_reporte', '>=', now()->subYear());
                    break;
            }
        }

        $reportes = $reportes->get();

        $conteoReportesPorEstado = [];

        foreach($estados as $estado) {
            $conteoReportesPorEstado[$estado] = 0;
        }
        $conteoReportesPorEstado['NO PROCEDE'] = $reportesNoProcede;

        foreach($reportes as $reporte) {
            if($reporte->estado_ultimo_historial == null) {
                $conteoReportesPorEstado['NO ASIGNADO'] = $conteoReportesPorEstado['NO ASIGNADO'] + 1;
            } else {
                $estado = Estado::find($reporte->estado_ultimo_historial->id)->nombre;
                $conteoReportesPorEstado[$estado] = $conteoReportesPorEstado[$estado] + 1;
            }
        }

        $chartReportesEstados = new Chart();

        $chartReportesEstados->labels($estados);
        $chartReportesEstados->dataset('', 'bar', $conteoReportesPorEstado)->backgroundColor([
            '#BFDBFE',       // bg-blue-100
            '#E9D5FF',     // bg-purple-100
            '#FEF3C7',       // bg-amber-100
            '#365314',     // bg-lime-800
            '#D1FAE5',     // bg-green-100
            '#FFEDD5',     // bg-orange-100
            '#EA580C',    // bg-orange-600
            '#1F2937',     // bg-gray-800
        ]);

        return view('estadisticas.index',
            [
                'chartReportesEstados' => $chartReportesEstados,
                'estados' => $estados,
                'conteoReportesPorEstado' => $conteoReportesPorEstado
            ]
        );
    }
}
