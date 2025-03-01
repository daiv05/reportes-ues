<?php

namespace App\Http\Controllers\Mantenimientos;

use App\Enums\GeneralEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mantenimientos\CategoriaReporte;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CategoriaReporteController extends Controller
{
    public function index(Request $request): View
    {
        $filtroNombre = $request->input('nombre-filter');

        $categoriasReportes = CategoriaReporte::when($filtroNombre, function ($query, $filtroNombre) {
            return $query->where('nombre', 'like', '%' . $filtroNombre . '%');
        })->paginate(GeneralEnum::PAGINACION->value)->appends($request->query());

        return view('mantenimientos.categoriaReportes.index', compact('categoriasReportes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|max:50|unique:categoria_reportes,nombre|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ\s]+$/',
            'activo' => 'nullable|boolean',
            'tiempo_promedio' => 'required|numeric|min:1',
            'unidad_tiempo' => 'required|in:minutos,horas,dias,meses',
            'descripcion' => 'required|max:250',
        ], [
            'nombre.required' => 'El nombre del tipo de bien es requerido',
            'nombre.max' => 'El nombre debe tener un máximo de 50 caracteres',
            'nombre.regex' => 'El nombre solo acepta letras, números y espacios.',
            'nombre.unique' => 'Ya existe un tipo de bien con ese nombre',
            'tiempo_promedio.required' => 'El tiempo promedio es requerido',
            'tiempo_promedio.numeric' => 'El tiempo promedio debe ser un número',
            'tiempo_promedio.min' => 'El tiempo promedio debe ser mayor a 0',
            'unidad_tiempo.required' => 'La unidad de tiempo es requerida',
            'unidad_tiempo.in' => 'La unidad de tiempo debe ser minutos, horas, días o meses',
            'descripcion.required' => 'La descripción es requerida',
            'descripcion.max' => 'La descripción debe tener un máximo de 250 caracteres',
        ]);

        CategoriaReporte::create($request->all());
        return redirect()->route('categoriaReportes.index')->with('message', [
            'type' => 'success',
            'content' => 'La categoría del reporte se ha creado exitosamente.'
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|max:50|unique:categoria_reportes,nombre,' . $id . '|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ\s\-,()]+$/',
            'activo' => 'nullable|boolean',
            'tiempo_promedio' => 'required|numeric|min:1',
            'unidad_tiempo' => 'required|in:minutos,horas,dias,meses',
            'descripcion' => 'required|max:250',
        ], [
            'nombre.required' => 'El nombre del tipo de bien es requerido',
            'nombre.max' => 'El nombre debe tener un máximo de 50 caracteres',
            'nombre.regex' => 'El nombre solo acepta letras, números y espacios.',
            'nombre.unique' => 'Ya existe un tipo de bien con ese nombre',
            'descripcion.required' => 'La descripción es requerida',
            'descripcion.max' => 'La descripción debe tener un máximo de 250 caracteres',
            'tiempo_promedio.required' => 'El tiempo promedio es requerido',
            'tiempo_promedio.numeric' => 'El tiempo promedio debe ser un número',
            'tiempo_promedio.min' => 'El tiempo promedio debe ser mayor a 0',
            'unidad_tiempo.required' => 'La unidad de tiempo es requerida',
            'unidad_tiempo.in' => 'La unidad de tiempo debe ser minutos, horas, días o meses',
        ]);

        $categoria = CategoriaReporte::findOrFail($id);
        $categoria->update($request->all());
        return redirect()->route('categoriaReportes.index')->with('message', [
            'type' => 'success',
            'content' => 'La categoría del reporte se ha actualizado exitosamente.'
        ]);
    }
}
