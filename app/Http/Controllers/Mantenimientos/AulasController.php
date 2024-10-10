<?php

namespace App\Http\Controllers\Mantenimientos;

use App\Http\Controllers\Controller;
use App\Models\General\Facultades;
use App\Models\Mantenimientos\Aulas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AulasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $aulas = Aulas::paginate(10);
        $facultades = Facultades::all();
        return view('mantenimientos.aulas.index', compact('aulas', 'facultades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('aulas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_facultad' => 'required|exists:facultades,id',
            'nombre' => 'required|max:50',
            'activo' => 'required|boolean',
        ]);

        Aulas::create($request->all());
        return redirect()->route('aulas.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $aula = Aulas::findOrFail($id);
        return view('aulas.show', compact('aula'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $aula = Aulas::findOrFail($id);
        return view('aulas.edit', compact('aula'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'id_facultad' => 'required|exists:facultades,id',
            'nombre' => 'required|max:50',
            'activo' => 'required|boolean',
        ]);

        $aula = Aulas::findOrFail($id);
        $aula->update($request->all());
        return redirect()->route('aulas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
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
