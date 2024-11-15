<?php

namespace App\Http\Controllers\Mantenimientos;

use App\Http\Controllers\Controller;
use App\Models\Mantenimientos\Recurso;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\Request;
use Illuminate\Http\RedirectResponse;

class RecursoController extends Controller
{
    public function index(Request $request): View
    {
        $query = Recurso::query();
        if ($request->has('nombre')) {
            $filtro = $request->input('nombre');
            $query->where('nombre', '%like%', $filtro);
        }
        $recursos = $query->paginate(10);
        return view('recursos.index', compact('recursos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|max:50',
            'activo' => 'nullable|boolean',
        ], [
            'nombre.required' => 'El nombre del recurso es requerido',
            'nombre.max' => 'El nombre debe tener un máximo de 50 caracteres'
        ]);

        Recurso::create($request->all());
        return redirect()->route('recursos.index')->with('message', [
            'type' => 'success',
            'content' => 'El recurso se ha creado exitosamente.'
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|max:50',
            'activo' => 'nullable|boolean',
        ], [
            'nombre.required' => 'El nombre del recurso es requerido',
            'nombre.max' => 'El nombre debe tener un máximo de 50 caracteres'
        ]);

        $recurso = Recurso::findOrFail($id);
        $recurso->update($request->all());
        return redirect()->route('recursos.index')->with('message', [
            'type' => 'success',
            'content' => 'El recurso se ha actualizado exitosamente.'
        ]);
    }
}
