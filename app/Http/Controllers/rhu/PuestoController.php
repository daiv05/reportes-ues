<?php

namespace App\Http\Controllers\rhu;

use App\Enums\GeneralEnum;
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

        $entidades = Entidades::where('activo', true)->get()->pluck('nombre', 'id');

        $puestos = Puesto::when($entidadFilter, function ($query, $entidadFilter) {
            return $query->where('id_entidad', $entidadFilter);
        })->when($search, function ($query, $search) {
            return $query->where('nombre', 'like', '%' . $search . '%');
        })->paginate(GeneralEnum::PAGINACION->value)->appends($request->query());

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
        $validated = $request->validate([
            'nombre' => 'required|string|max:50|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ\s]+$/',
            'id_entidad' => 'required|integer|exists:entidades,id',
            'activo' => 'required|boolean',
        ], [
            'nombre.regex' => 'El nombre solo acepta letras, números y espacios',
            'id_entidad.exists' => 'La entidad seleccionada no existe.',
            'nombre.max' => 'El nombre debe tener un máximo de 50 caracteres.',
        ]);

        $existingPuesto = Puesto::where('nombre', $validated['nombre'])
            ->where('id_entidad', $validated['id_entidad'])
            ->first();

        if ($existingPuesto) {
            return back()->withErrors(['nombre' => 'El puesto con ese nombre ya existe para esta entidad.'])
                ->withInput();
        }

        $puesto = new Puesto();
        $puesto->nombre = $validated['nombre'];
        $puesto->id_entidad = $validated['id_entidad'];
        $puesto->activo = $validated['activo'];
        $puesto->save();

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
        $validated = $request->validate([
            'nombre' => 'required|string|max:50|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ\s]+$/',
            'id_entidad' => 'required|integer|exists:entidades,id',
            'activo' => 'required|boolean',
        ], [
            'nombre.regex' => 'El nombre solo acepta letras, números y espacios',
            'id_entidad.exists' => 'La entidad seleccionada no existe.',
            'nombre.max' => 'El nombre debe tener un máximo de 50 caracteres.',
        ]);

        $existingPuesto = Puesto::where('nombre', $validated['nombre'])
            ->where('id_entidad', $validated['id_entidad'])
            ->where('id', '!=', $id)
            ->first();

        if ($existingPuesto) {
            return back()->withErrors(['nombre' => 'El puesto con ese nombre ya existe para esta entidad.'])
                ->withInput();
        }

        $puesto = Puesto::findOrFail($id);
        $puesto->nombre = $validated['nombre'];
        $puesto->id_entidad = $validated['id_entidad'];
        $puesto->activo = $validated['activo'];
        $puesto->save();

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
