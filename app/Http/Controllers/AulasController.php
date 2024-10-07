<?php

namespace App\Http\Controllers;

use App\Models\Aulas;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AulasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $aulas = Aulas::all();
        return view('mantenimientos.aulas.index', compact('aulas'));
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
            'nombre' => 'required',
            'id_facultad' => 'required|exists:facultades,id',
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
            'nombre' => 'required',
            'id_facultad' => 'required|exists:facultades,id',
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
