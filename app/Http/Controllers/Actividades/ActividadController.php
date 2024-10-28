<?php

namespace App\Http\Controllers\Actividades;

use App\Http\Controllers\Controller;
use App\Imports\CalendarioImport;
use App\Imports\HorarioImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ActividadController extends Controller
{
    public function importarExcel(Request $request)
    {
        $import = null;
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv',
            'tipo_actividad' => 'required'
        ]);
        // Procesar el archivo Excel y extraer los datos
        if ($request->input('tipo_actividad') == 'evento') {
            $import = new CalendarioImport();
        } else {
            $import = new HorarioImport();
        }
        Excel::import($import, $request->file('excel_file'));

        // Asumamos que el importador guarda los datos importados en una variable
        // $import->getData() obtendrá los datos procesados, este método lo debes crear
        $data = $import->getData();

        // Regresamos los datos a la vista
        return view('actividades.importacion-actividades.importacion-actividades', [
            'excelData' => $data,
            'tipoActividad' => $request->input('tipo_actividad')
        ]);
    }
}
