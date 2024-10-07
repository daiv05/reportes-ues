<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Escuela;

class EscuelaController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener todas las escuelas para mostrarlas en la tabla debajo del formulario
        $escuelas = Escuela::all();

        // Retornar la vista del formulario de creación con las escuelas
        return view('mantenimiento.matenimiento_escuela', compact('escuelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar la solicitud
        $validatedData = $request->validate([
            'id_facultad' => 'required|integer',
            'nombre' => 'required|string|max:50',
            'activo' => 'required|boolean',
        ]);

        // Crear la escuela
        Escuela::create($validatedData);

        // Redirigir con un mensaje de éxito al formulario de creación
        return redirect()->route('escuela.create')->with('message', [
            'type' => 'success', // Cambia 'success' por 'error', 'warning' o 'info' según la acción
            'content' => 'Escuela creada exitosamente'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar la solicitud
        $validatedData = $request->validate([
            'id_facultad' => 'required|integer',
            'nombre' => 'required|string|max:50',
            'activo' => 'required|boolean',
        ]);

        // Buscar y actualizar la escuela
        $escuela = Escuela::findOrFail($id);
        $escuela->update($validatedData);

        // Redirigir con un mensaje de éxito
        return redirect()->route('escuela.create')->with('message', [
            'type' => 'info', // Cambia 'success' por 'error', 'warning' o 'info' según la acción
            'content' => 'Escuela actualizada exitosamente'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Buscar y eliminar la escuela
        $escuela = Escuela::findOrFail($id);
        $escuela->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('escuela.create')->with('message', [
            'type' => 'warning', // Cambia 'success' por 'error', 'warning' o 'info' según la acción
            'content' => 'Escuela eliminada exitosamente'
        ]);
    }
}
