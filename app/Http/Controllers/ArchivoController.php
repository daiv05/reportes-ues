<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchivoController extends Controller
{
    public function descargarArchivo($seccion)
    {

        $archivos = [
            'importacion_actividades' => 'private/formatos/EVENTOSYEVALUACIONES.xlsx',
            'bienes' => 'private/formatos/BIENES.xlsx',
            'recursos' => 'private/formatos/RECURSOS.xlsx',
            'asignaturas' => 'private/formatos/ASIGNATURAS.xlsx',
            'clases' => 'private/formatos/CLASES.xlsx',
            'empleados' => 'private/formatos/EMPLEADOS.xlsx',
            'locales' => 'private/formatos/LOCALES.xlsx'
        ];


        if (isset($archivos[$seccion]) && Storage::exists($archivos[$seccion])) {

            return response()->download(storage_path("app/{$archivos[$seccion]}"));
        } else {

            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }
    }
}
