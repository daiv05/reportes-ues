<?php

namespace App\Http\Controllers\Mantenimientos;

use App\Http\Controllers\Controller;
use App\Models\Mantenimientos\Recurso;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class RecursoController extends Controller
{
    public function index(Request $request): View
    {
        $query = Recurso::query();
        if ($request->has('nombre-filter')) {
            $filtro = $request->input('nombre-filter');
            $query->where('nombre', 'like', '%' . $filtro . '%');
        }
        $recursos = $query->paginate(10)->appends($request->query());
        return view('mantenimientos.recursos.index', compact('recursos'));
    }

    public function create(): View
    {
        return view('mantenimientos.recursos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|max:50|unique:recursos,nombre',
            'activo' => 'nullable|boolean',
        ], [
            'nombre.required' => 'El nombre del recurso es requerido',
            'nombre.max' => 'El nombre debe tener un máximo de 50 caracteres',
            'nombre.unique' => 'Ya existe un recurso con ese nombre.',
        ]);
        Recurso::create($request->all());
        return redirect()->route('recursos.index')->with('message', [
            'type' => 'success',
            'content' => 'El recurso se ha creado exitosamente.'
        ]);
    }


    public function edit(Recurso $recurso): View
    {
        return view('mantenimientos.recursos.edit', compact('recurso'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|max:50|unique:recursos,nombre,' . $id,
            'activo' => 'nullable|boolean',
        ], [
            'nombre.required' => 'El nombre del recurso es requerido',
            'nombre.max' => 'El nombre debe tener un máximo de 50 caracteres',
            'nombre.unique' => 'Ya existe un recurso con ese nombre.',
        ]);

        $recurso = Recurso::findOrFail($id);
        $recurso->update($request->all());
        return redirect()->route('recursos.index')->with('message', [
            'type' => 'success',
            'content' => 'El recurso se ha actualizado exitosamente.'
        ]);
    }

}
