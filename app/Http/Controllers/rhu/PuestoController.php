<?php

namespace App\Http\Controllers\rhu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\rhu\Puesto;
use App\Models\Mantenimientos\Departamento;

class PuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $departamentos = Departamento::all();
        $idDepartamento = $request->input('id_departamento');
        $search = $request->input('search');

        $puestos = Puesto::query();

        // Filtro por departamento si está seleccionado
        if ($idDepartamento) {
            $puestos->where('id_departamento', $idDepartamento);
        }

        // Filtro por búsqueda de nombre
        if ($search) {
            $puestos->where('nombre', 'like', '%' . $search . '%');
        }

        // Paginación
        $puestos = $puestos->paginate(10);

        return view('rhu.puestos.index', compact('puestos', 'departamentos'));
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
            'id_departamento' => 'required|integer|exists:departamentos,id',
            'activo' => 'required|boolean',
        ]);

        // Crear el puesto con los datos validados
        $puesto = new Puesto();
        $puesto->nombre = $validated['nombre'];
        $puesto->id_departamento = $validated['id_departamento'];
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
            'id_departamento' => 'required|integer|exists:departamentos,id',
            'activo' => 'required|boolean',
        ]);

        // Buscar el puesto y actualizarlo
        $puesto = Puesto::findOrFail($id);
        $puesto->nombre = $validated['nombre'];
        $puesto->id_departamento = $validated['id_departamento'];
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