<?php

namespace App\Http\Controllers\Reporte;

use App\Models\Reportes\Estado;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EstadoController extends Controller
{
    public function estadosReporte($idReporte)
    {
        return response()->json(Estado::all());
    }
}
