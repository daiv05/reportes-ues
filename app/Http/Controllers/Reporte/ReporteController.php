<?php

namespace App\Http\Controllers\Reporte;

use App\Http\Controllers\Controller;

class ReporteController extends Controller
{
    public function detalle()
    {
        return view('reportes.detail');
    }
}
