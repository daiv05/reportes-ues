<?php

namespace App\Http\Controllers\Actividades;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportActividadClaseRequest;
use App\Imports\CalendarioImport;
use App\Imports\HorarioImport;
use App\Models\General\Dia;
use App\Models\General\Modalidad;
use App\Models\General\TipoClase;
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

        // Guardamos los datos en la sesión para que se mantengan en caso de errores
        session(['excelData' => $data]);

        // Regresamos los datos a la vista
        return view('actividades.importacion-actividades.importacion-actividades', [
            'excelData' => $data,
            'tipoActividad' => $request->input('tipo_actividad'),
        ]);
    }

    public function storeClases(ImportActividadClaseRequest $request)
    {
        // Procesar los datos y guardarlos en la base de datos
        // $request->all() obtendrá todos los datos enviados por el formulario
        // Este método lo debes crear

        $data = $request->all();

        // Guardar los datos en la base de datos
        // Este método lo debes crear
        dd($data);
    }
}
