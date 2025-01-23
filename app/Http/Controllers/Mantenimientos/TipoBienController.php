<?php

namespace App\Http\Controllers\Mantenimientos;

use App\Enums\GeneralEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reportes\TipoBien;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TipoBienController extends Controller
{
    public function index(Request $request): View
    {
        $query = TipoBien::query();
        if ($request->has('nombre-filter')) {
            $filtro = $request->input('nombre-filter');
            $query->where('nombre', 'like', '%' . $filtro . '%');
        }
        $tiposBienes = $query->paginate(GeneralEnum::PAGINACION->value)->appends($request->query());
        return view('mantenimientos.tiposBienes.index', compact('tiposBienes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|max:50|unique:tipos_bienes,nombre|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ\s]+$/',
            'activo' => 'nullable|boolean',
        ], [
            'nombre.required' => 'El nombre del tipo de bien es requerido',
            'nombre.max' => 'El nombre debe tener un máximo de 50 caracteres',
            'nombre.regex' => 'El nombre solo acepta letras, números y espacios.',
            'nombre.unique' => 'Ya existe un tipo de bien con ese nombre'
        ]);

        TipoBien::create($request->all());
        return redirect()->route('tiposBienes.index')->with('message', [
            'type' => 'success',
            'content' => 'El tipo de bien se ha creado exitosamente.'
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|max:50|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ\s]+$/|unique:bienes,nombre,' . $id,
            'activo' => 'nullable|boolean'
        ], [
            'nombre.required' => 'El nombre del tipo de bien es requerido',
            'nombre.regex' => 'El nombre solo acepta letras, números y espacios.',
            'nombre.max' => 'El nombre debe tener un máximo de 50 caracteres',
            'nombre.unique' => 'Ya existe un tipo de bien con ese nombre'
        ]);

        $tipoBien = TipoBien::findOrFail($id);
        $tipoBien->update($request->all());
        return redirect()->route('tiposBienes.index')->with('message', [
            'type' => 'success',
            'content' => 'El tipo de bien se ha actualizado exitosamente.'
        ]);
    }
}
