<?php

namespace App\Http\Controllers\Actividades;

use App\Http\Controllers\Controller;
use App\Models\Mantenimientos\TipoActividad;
use Illuminate\Http\Request;

class TipoActividadController extends Controller
{
    public function index()
    {
        $tiposActividades = TipoActividad::all();
        return view('actividades.tipo_actividad', compact('tiposActividades'));
    }
    public function create()
    {

    }
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
    public function show(string $id)
    {
        //
    }
    public function edit($id)
    {
        $tipoActividad = TipoActividad::findOrFail($id);
        return view('actividades.tipo_actividad', compact('tipoActividad'));
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'activo' => 'required|boolean',
        ]);
        $tipoActividad = TipoActividad::findOrFail($id);
        $tipoActividad->update($validatedData);
        return redirect()->route('actividad-tipo.index')->with('success', 'Tipo de actividad actualizado exitosamente');
    }
    public function destroy($id)
    {
        $tipoActividad = TipoActividad::findOrFail($id);
        $tipoActividad->delete();

        return redirect()->route('actividad-tipo.index')->with('success', 'Tipo de actividad eliminado exitosamente');
    }
}
