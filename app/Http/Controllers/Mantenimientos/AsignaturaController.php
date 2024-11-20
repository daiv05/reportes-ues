<?php

namespace App\Http\Controllers\Mantenimientos;

use App\Http\Controllers\Controller;
use App\Models\Mantenimientos\Asignatura;
use App\Models\Mantenimientos\Escuela;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AsignaturaController extends Controller
{
    public function index(): View
    {
        $asignaturas = Asignatura::paginate(2);
        $escuelas = Escuela::all();
        return view('mantenimientos.asignatura.index', compact('asignaturas', 'escuelas'))->with('message', [
            'type' => 'success',
            'content' => 'La asignatura se ha creado exitosamente.'
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
        return view('asignatura.create')->with('message', [
            'type' => 'info',
            'content' => 'Bienvenido al mantenimiento de asignatura.'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validar la solicitud
        // Validar la solicitud con un mensaje personalizado en caso de error
        $request->validate([
            'id_escuela' => 'required|exists:escuelas,id',
            'nombre' => 'required|max:50|unique:asignaturas,nombre', // Validación de nombre único
            'activo' => 'required|boolean',
        ], [
            'nombre.unique' => 'El nombre de la asignatura ya existe. Por favor, elige otro nombre.',
        ]);

        Asignatura::create($request->all());
        return redirect()->route('asignatura.index')
        ->with('message', [
            'type' => 'success',
            'content' => 'La asignatura se ha creado exitosamente.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $asignatura = Asignatura::findOrFail($id);
        return view('asignatura.show', compact('asignatura'))->with('message', [
            'type' => 'success',
            'content' => 'La asignatura se ha creado exitosamente.'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $asignatura = Asignatura::findOrFail($id);
        return view('asignatura.edit', compact('asignatura'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'id_escuela' => 'required|exists:escuelas,id',
            'nombre' => 'required|max:50',
            'activo' => 'required|boolean',
        ]);

        $asignatura = Asignatura::findOrFail($id);
        $asignatura->update($request->all());
        return redirect()->route('asignatura.index')->with('message', [
            'type' => 'success',
            'content' => 'El asignatura se ha actualizado exitosamente.'
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $asignatura = Asignatura::findOrFail($id);
        $asignatura->delete();
        return redirect()->route('asignatura.index')->with('message', [
            'type' => 'success',
            'content' => 'La asignatura se ha eliminado exitosamente.'
        ]);
    }

    public function toggleActivo(Asignatura $asignatura): RedirectResponse
    {
        $asignatura->activo = !$asignatura->activo;
        $asignatura->save();
        return redirect()->route('asignatura.index');
    }
}
