<?php

namespace App\Http\Controllers\Mantenimientos;

use App\Enums\GeneralEnum;
use App\Http\Controllers\Controller;
use App\Models\Mantenimientos\UnidadMedida;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class UnidadMedidaController extends Controller
{
    public function index(Request $request): View
    {
        $query = UnidadMedida::query();
        if ($request->has('nombre')) {
            $filtro = $request->input('nombre');
            $query->where('nombre', 'like', '%' . $filtro . '%');
        }
        $unidades = $query->paginate(GeneralEnum::PAGINACION->value)->appends($request->query());
        return view('mantenimientos.unidad_medida.index', compact('unidades'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|max:50|unique:unidades_medida,nombre|regex:/^[a-zA-Z0-9\s]+$/',
            'activo' => 'nullable|boolean',
        ], [
            'nombre.required' => 'El nombre de la unidad es requerido',
            'nombre.regex' => 'El nombre solo acepta letras, números y espacios.',
            'nombre.unique' => 'Ya existe una unidad de medida con ese nombre',
            'nombre.max' => 'El nombre debe tener un máximo de 50 caracteres'
        ]);

        UnidadMedida::create($request->all());
        return redirect()->route('unidades-medida.index')->with('message', [
            'type' => 'success',
            'content' => 'La unidad de medida se ha creado exitosamente.'
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|max:50|unique:unidades_medida,nombre,' . $id,
            'activo' => 'nullable|boolean',
        ], [
            'nombre.required' => 'El nombre de la unidad es requerido',
            'nombre.max' => 'El nombre debe tener un máximo de 50 caracteres'
        ]);

        $unidad = UnidadMedida::findOrFail($id);
        $unidad->update($request->all());
        return redirect()->route('unidades-medida.index')->with('message', [
            'type' => 'success',
            'content' => 'La unidad de medida se ha actualizado exitosamente.'
        ]);
    }
}
