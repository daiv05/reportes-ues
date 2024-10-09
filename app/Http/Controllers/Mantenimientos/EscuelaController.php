<?php

namespace App\Http\Controllers\Mantenimientos;

use App\Http\Controllers\Controller;
use App\Models\General\Facultades;
use App\Models\Mantenimientos\Escuela;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EscuelaController extends Controller
{
    public function index(): View
    {
        $escuelas = Escuela::paginate(10);
        $facultades = Facultades::all();
        return view('mantenimientos.escuela.index', compact('escuelas', 'facultades'))->with('message', [
            'type' => 'success',
            'content' => 'El aula se ha creado exitosamente.'
        ]);
    }

      /**
     * Display a listing of the resource.
     */
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('escuela.create')->with('message', [
            'type' => 'info',
            'content' => 'Bienvenido al mantenimiento de aulas.'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validar la solicitud
        $request->validate([
            'id_facultad' => 'required|exists:facultades,id',
            'nombre' => 'required|max:50',
            'activo' => 'required|boolean',
        ]);

        Escuela::create($request->all());
        return redirect()->route('escuela.index')->with('message', [
            'type' => 'success',
            'content' => 'El aula se ha creado exitosamente.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $escuela = Escuela::findOrFail($id);
        return view('escuela.show', compact('escuela'))->with('message', [
            'type' => 'success',
            'content' => 'El aula se ha creado exitosamente.'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $escuela = Escuela::findOrFail($id);
        return view('escuela.edit', compact('escuela'))->with('message', [
            'type' => 'success',
            'content' => 'El aula se ha editado exitosamente.'
        ]);
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

        $escuela = Escuela::findOrFail($id);
        $escuela->update($request->all());
        return redirect()->route('escuela.index')->with('message', [
            'type' => 'success',
            'content' => 'El aula se ha actualizado exitosamente.'
        ]);
    }
  /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $escuela = Escuela::findOrFail($id);
        $escuela->delete();
        return redirect()->route('escuela.index')->with('message', [
            'type' => 'success',
            'content' => 'El aula se ha creado exitosamente.'
        ]);
    }

    public function toggleActivo(Escuela $escuela): RedirectResponse
    {
        $escuela->activo = !$escuela->activo;
        $escuela->save();
        return redirect()->route('escuela.index')->with('message', [
            'type' => 'success',
            'content' => 'El aula se ha creado exitosamente.'
        ]);
    }
}
