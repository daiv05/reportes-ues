<?php

namespace App\Http\Controllers\Mantenimientos;

use App\Enums\GeneralEnum;
use App\Http\Controllers\Controller;
use App\Models\General\Facultades;
use App\Models\Mantenimientos\Aulas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\Mantenimiento\StoreAulaRequest;


class AulasController extends Controller
{
    public function index(Request $request): View
    {
        $nombreFilter = request('nombre-filter');
        $aulas = Aulas::when($nombreFilter, function ($query, $nombreFilter) {
                return $query->where('nombre', 'like', "%$nombreFilter%");
            })
            ->paginate(GeneralEnum::PAGINACION->value)->appends($request->query());
        $facultades = Facultades::all();
        return view('mantenimientos.aulas.index', compact('aulas', 'facultades'));
    }

    public function create(): View
    {
        return view('aulas.create');
    }

    public function store(StoreAulaRequest  $request): RedirectResponse
    {
        Aulas::create($request->all());
        return redirect()->route('aulas.index') ->with('message', [
            'type' => 'success',
            'content' => 'Aula creada exitosamente'
        ]);
    }


    public function show(string $id): View
    {
        $aula = Aulas::findOrFail($id);
        return view('aulas.show', compact('aula'));
    }


    public function edit(string $id): View
    {
        $aula = Aulas::findOrFail($id);
        return view('aulas.edit', compact('aula'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {

        $aula = Aulas::findOrFail($id);
        if ($aula->nombre !== $request->input('nombre')) {
            $nombre = $request->input('nombre');
            $idFacultad = $request->input('id_facultad');
            $existingAula = Aulas::where('nombre', $nombre)
                ->where('id_facultad', $idFacultad)
                ->where('id', '!=', $id)
                ->first();
            if ($existingAula) {
                return redirect()->route('aulas.index')->with('message', [
                    'type' => 'warning',
                    'content' => 'Ya existe un aula con este nombre en la facultad seleccionada.'
                ]);
            }
        }
        $aula->update($request->only(['nombre', 'id_facultad', 'activo']));
        return redirect()->route('aulas.index')->with('message', [
            'type' => 'success',
            'content' => 'Aula actualizada exitosamente'
        ]);
    }



    public function destroy(string $id): RedirectResponse
    {
        $aula = Aulas::findOrFail($id);
        $aula->delete();
        return redirect()->route('aulas.index');
    }

    public function toggleActivo(Aulas $aula): RedirectResponse
    {
        $aula->activo = !$aula->activo;
        $aula->save();
        return redirect()->route('aulas.index');
    }
}
