<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchivoController extends Controller
{
    public function descargarArchivo($seccion)
    {

        $archivos = [
            'importacion_actividades' => 'public/formatos/EVENTOSYEVALUACIONES.xlsx',
            'bienes' => 'public/formatos/BIENES.xlsx',
            'recursos' => 'public/formatos/RECURSOS.xlsx',
            'asignaturas' => 'public/formatos/ASIGNATURAS.xlsx',
            'clases' => 'public/formatos/CLASES.xlsx',
            'empleados' => 'public/formatos/EMPLEADOS.xlsx',
            'locales' => 'public/formatos/LOCALES.xlsx'
        ];


        if (isset($archivos[$seccion]) && Storage::exists($archivos[$seccion])) {

            return response()->download(storage_path("app/{$archivos[$seccion]}"));
        } else {

            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }
    }
}
