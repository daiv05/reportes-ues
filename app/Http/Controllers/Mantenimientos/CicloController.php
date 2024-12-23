<?php

namespace App\Http\Controllers\Mantenimientos;

use App\Enums\GeneralEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mantenimientos\Ciclo;
use App\Models\General\TipoCiclo;
use App\Http\Requests\Mantenimiento\CicloRequest;
use App\Mail\EnvioMailable;
use Illuminate\Support\Facades\Mail;

class CicloController extends Controller
{

    public function index(Request $request)
    {
        $ciclos = Ciclo::with('tipoCiclo')->paginate(GeneralEnum::PAGINACION->value)->appends($request->query());
        $tiposCiclos = TipoCiclo::all();

        $tiposCiclos = $tiposCiclos->pluck('nombre', 'id')->toArray();

        $estados = [
            1 => 'ACTIVO',
            0 => 'INACTIVO',
        ];


        return view('mantenimientos.ciclos.index', compact('ciclos', 'tiposCiclos', 'estados'));
    }

    public function store(CicloRequest $request)
    {
        if ($request->activo) {
            Ciclo::where('activo', true)->update(['activo' => false]);
        }

        $ciclo = Ciclo::create($request->validated());

        return redirect()->route('ciclos.index')
            ->with('message', [
                'type' => 'success',
                'content' => 'Ciclo creado exitosamente'
            ]);
    }

    public function update(CicloRequest $request, $id)
    {
        $ciclo = Ciclo::findOrFail($id);

        if ($request->activo) {
            Ciclo::where('activo', true)->where('id', '<>', $id)->update(['activo' => false]);
        }

        $ciclo->update($request->validated());

        return redirect()->route('ciclos.index')
            ->with('message', [
                'type' => 'success',
                'content' => 'Ciclo actualizado exitosamente'
            ]);
    }
}
