<?php

namespace App\Http\Controllers\Mantenimientos;

use App\Enums\GeneralEnum;
use App\Http\Controllers\Controller;
use App\Models\General\Facultades;
use App\Models\Mantenimientos\Escuela;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Mantenimiento\StoreEscuelaRequest;
use App\Http\Requests\Mantenimiento\UpdateEscuelaRequest;

use Illuminate\View\View;

class EscuelaController extends Controller
{
    public function index(Request $request): View
    {
        $nombreFilter = $request->get('nombre-filter');

        $escuelas = Escuela::when($nombreFilter, function ($query, $nombreFilter) {
            return $query->where('nombre', 'like', "%$nombreFilter%");
        })->paginate(GeneralEnum::PAGINACION->value)->appends($request->query());
        $facultades = Facultades::where('activo', true)->get();
        return view('mantenimientos.escuela.index', compact('escuelas', 'facultades'));
    }

    public function create(): View
    {
        return view('escuela.create');
    }

    public function store(StoreEscuelaRequest $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|max:50|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ\s]+$/',
            'facultad_id' => 'required|exists:facultades,id',
            'activo' => 'required'
        ], [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.max' => 'El campo nombre no debe ser mayor a 50 caracteres.',
            'nombre.regex' => 'El campo nombre solo acepta letras, números y espacios.',
            'facultad_id.required' => 'El campo facultad es obligatorio.',
            'facultad_id.exists' => 'La facultad seleccionada no existe.',
            'activo.required' => 'El campo activo es obligatorio.'
        ]);
        Escuela::create($request->all());
        return redirect()->route('escuela.index')->with('message', [
            'type' => 'success',
            'content' => 'El escuela se ha creado exitosamente.'
        ]);
    }


    public function show(string $id): View
    {
        $escuela = Escuela::findOrFail($id);
        return view('escuela.show', compact('escuela'));
    }


    public function edit(string $id): View
    {
        $escuela = Escuela::findOrFail($id);
        return view('escuela.edit', compact('escuela'));
    }

    public function update(UpdateEscuelaRequest $request, string $id): RedirectResponse
    {
        $escuela = Escuela::findOrFail($id);
        $escuela->update($request->all());

        return redirect()->route('escuela.index')->with('message', [
            'type' => 'success',
            'content' => 'La escuela se ha actualizado exitosamente.'
        ]);
    }


    public function destroy(string $id): RedirectResponse
    {
        $escuela = Escuela::findOrFail($id);
        $escuela->delete();
        return redirect()->route('escuela.index');
    }

    public function toggleActivo(Escuela $escuela): RedirectResponse
    {
        $escuela->activo = !$escuela->activo;
        $escuela->save();
        return redirect()->route('escuela.index');
    }
}
