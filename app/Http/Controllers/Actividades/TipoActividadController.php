<?php

namespace App\Http\Controllers\Actividades;

use App\Http\Controllers\Controller;
use App\Models\Mantenimientos\TipoActividad;
use Illuminate\Http\Request;

class TipoActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los tipos de actividades para mostrarlos en la tabla debajo del formulario
        $tiposActividades = TipoActividad::all();
        return view('actividades.tipo_actividad', compact('tiposActividades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }


    /**
     * Store a newly created resource in storage.
     */
    // Método para almacenar el nuevo tipo de actividad
    public function store(Request $request)
    {
        // Validar la solicitud
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'activo' => 'required|boolean',
        ]);

        // Crear el tipo de actividad
        TipoActividad::create($validatedData);

        // Redirigir con un mensaje de éxito al formulario de creación
        return redirect()->route('actividad-tipo.index')->with('success', 'Tipo de actividad creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tipoActividad = TipoActividad::findOrFail($id);
        return view('actividades.tipo_actividad', compact('tipoActividad'));
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar la solicitud
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'activo' => 'required|boolean',
        ]);

        // Buscar y actualizar el tipo de actividad
        $tipoActividad = TipoActividad::findOrFail($id);
        $tipoActividad->update($validatedData);

        // Redirigir con un mensaje de éxito
        return redirect()->route('actividad-tipo.index')->with('success', 'Tipo de actividad actualizado exitosamente');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tipoActividad = TipoActividad::findOrFail($id);
        $tipoActividad->delete();

        return redirect()->route('actividad-tipo.index')->with('success', 'Tipo de actividad eliminado exitosamente');
    }
}
