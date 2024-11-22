<?php

namespace App\Http\Controllers\Mantenimientos;

use App\Http\Controllers\Controller;
use App\Models\General\Facultades;
use App\Models\Mantenimientos\Aulas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\Mantenimiento\StoreAulaRequest;
use App\Http\Requests\Mantenimiento\UpdateAulaRequest;

class AulasController extends Controller
{
    public function index(): View
    {
        $aulas = Aulas::paginate(10);
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

    public function update(UpdateAulaRequest  $request, string $id): RedirectResponse
    {
        $aula = Aulas::findOrFail($id);
        $aula->update($request->all());
        return redirect()->route('aulas.index') ->with('message', [
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
