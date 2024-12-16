<?php

namespace App\Http\Controllers\Mantenimientos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reportes\Bien;
use App\Models\Reportes\TipoBien;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class BienController extends Controller
{
    public function index(Request $request): View
    {
        $filtroNombre = $request->input('nombre-filter');
        $filtroTipo = $request->input('tipoBien');
        $bienes = Bien::when($filtroTipo, function ($query, $filtroTipo) {
            return $query->where('id_tipo_bien', $filtroTipo);
        })->when($filtroNombre, function ($query, $filtroNombre) {
            return $query->where('nombre', 'like', '%' . $filtroNombre . '%');
        })->paginate(10)->appends($request->query());
        $tiposBienes = TipoBien::all();
        return view('mantenimientos.bienes.index', compact('tiposBienes', 'bienes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|max:50|unique:bienes,nombre',
            'id_tipo_bien' => 'required|exists:tipos_bienes,id',
            'descripcion' => 'required|max:250',
            'codigo' => 'required|max:50|unique:bienes,codigo',
            'activo' => 'nullable|boolean',
        ], [
            'nombre.required' => 'El nombre del bien es requerido',
            'nombre.max' => 'El nombre debe tener un máximo de 50 caracteres',
            'nombre.unique' => 'Ya existe un bien con ese nombre',
            'id_tipo_bien.required' => 'Debe específicar el tipo de bien',
            'id_tipo_bien.exists' => 'El tipo de bien no existe',
            'descripcion.required' => 'La descripción es requerida',
            'descripcion.max' => 'La descripción debe tener un máximo de 250 caracteres',
            'codigo.required' => 'El código del bien es requerido',
            'codigo.max' => 'El código debe tener un máximo de 50 caracteres',
            'codigo.unique' => 'Ya existe un bien con ese código',
        ]);

        Bien::create($request->all());
        return redirect()->route('bienes.index')->with('message', [
            'type' => 'success',
            'content' => 'El bien se ha creado exitosamente.'
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|max:50|unique:bienes,nombre,' . $id,
            'id_tipo_bien' => 'required|exists:tipos_bienes,id',
            'descripcion' => 'required|max:250',
            'codigo' => 'required|max:50|unique:bienes,codigo,' . $id,
            'activo' => 'nullable|boolean',
        ], [
            'nombre.required' => 'El nombre del bien es requerido',
            'nombre.max' => 'El nombre debe tener un máximo de 50 caracteres',
            'nombre.unique' => 'Ya existe un bien con ese nombre',
            'id_tipo_bien.required' => 'Debe específicar el tipo de bien',
            'id_tipo_bien.exists' => 'El tipo de bien no existe',
            'descripcion.required' => 'La descripción es requerida',
            'descripcion.max' => 'La descripción debe tener un máximo de 250 caracteres',
            'codigo.required' => 'El código del bien es requerido',
            'codigo.max' => 'El código debe tener un máximo de 50 caracteres',
            'codigo.unique' => 'Ya existe un bien con ese código',
        ]);

        $bien = Bien::findOrFail($id);
        $bien->update($request->all());
        return redirect()->route('bienes.index')->with('message', [
            'type' => 'success',
            'content' => 'El bien se ha actualizado exitosamente.'
        ]);
    }
}
