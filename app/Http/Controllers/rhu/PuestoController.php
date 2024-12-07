<?php

namespace App\Http\Controllers\rhu;

use App\Http\Controllers\Controller;
use App\Models\rhu\Entidades;
use App\Models\rhu\Puesto;
use Illuminate\Http\Request;

class PuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $entidadFilter = $request->input('entidad-filter');
        $search = $request->input('nombre-filter');

        $entidades = Entidades::all()->pluck('nombre', 'id');

        $puestos = Puesto::when($entidadFilter, function ($query, $entidadFilter) {
            return $query->where('id_entidad', $entidadFilter);
        })->when($search, function ($query, $search) {
            return $query->where('nombre', 'like', '%' . $search . '%');
        })->paginate(10)->appends($request->query());

        return view('rhu.puestos.index', compact('puestos', 'entidades'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $validated = $request->validate([
            'nombre' => 'required|string|max:50',
            'id_entidad' => 'required|integer|exists:entidades,id',
            'activo' => 'required|boolean',
        ]);

        // Crear el puesto con los datos validados
        $puesto = new Puesto();
        $puesto->nombre = $validated['nombre'];
        $puesto->id_entidad = $validated['id_entidad'];
        $puesto->activo = $validated['activo'];
        $puesto->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('puestos.index')->with('message', [
            'type' => 'success',
            'content' => 'Puesto creado exitosamente.'
        ]);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar los datos recibidos
        $validated = $request->validate([
            'nombre' => 'required|string|max:50',
            'id_entidad' => 'required|integer|exists:entidades,id',
            'activo' => 'required|boolean',
        ]);

        // Buscar el puesto y actualizarlo
        $puesto = Puesto::findOrFail($id);
        $puesto->nombre = $validated['nombre'];
        $puesto->id_entidad = $validated['id_entidad'];
        $puesto->activo = $validated['activo'];
        $puesto->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('puestos.index')->with('message', [
            'type' => 'success',
            'content' => 'Puesto actualizado exitosamente.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
