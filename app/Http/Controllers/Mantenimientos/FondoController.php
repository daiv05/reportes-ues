<?php

namespace App\Http\Controllers\Mantenimientos;

use App\Enums\GeneralEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mantenimientos\Fondo;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class FondoController extends Controller
{
    public function index(Request $request): View
    {
        $query = Fondo::query();
        if ($request->has('nombre-filter')) {
            $filtro = $request->input('nombre-filter');
            $query->where('nombre', 'like', '%' . $filtro . '%');
        }
        $fondos = $query->paginate(GeneralEnum::PAGINACION->value)->appends($request->query());
        return view('mantenimientos.fondos.index', compact('fondos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|max:50|unique:fondos,nombre|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ\s]+$/',
            'descripcion' => 'nullable|string|max:255',
            'activo' => 'nullable|boolean',
        ], [
            'nombre.required' => 'El nombre del fondo es requerido',
            'nombre.max' => 'El nombre debe tener un máximo de 50 caracteres',
            'nombre.regex' => 'El nombre solo acepta letras, números y espacios.',
            'nombre.unique' => 'Ya existe un fondo con ese nombre'
        ]);

        Fondo::create($request->all());
        return redirect()->route('fondos.index')->with('message', [
            'type' => 'success',
            'content' => 'El fondo se ha creado exitosamente.'
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|max:50|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ\s]+$/|unique:fondos,nombre,' . $id,
            'descripcion' => 'nullable|string|max:255',
            'activo' => 'nullable|boolean'
        ], [
            'nombre.required' => 'El nombre del fondo es requerido',
            'nombre.regex' => 'El nombre solo acepta letras, números y espacios.',
            'nombre.max' => 'El nombre debe tener un máximo de 50 caracteres',
            'nombre.unique' => 'Ya existe un fondo con ese nombre'
        ]);

        $fondo = Fondo::findOrFail($id);
        $fondo->update($request->all());
        return redirect()->route('fondos.index')->with('message', [
            'type' => 'success',
            'content' => 'El fondo se ha actualizado exitosamente.'
        ]);
    }
}
