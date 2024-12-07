<?php

namespace App\Http\Controllers\Mantenimientos;

use App\Http\Controllers\Controller;
use App\Models\Mantenimientos\Asignatura;
use App\Models\Mantenimientos\Escuela;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AsignaturaController extends Controller
{
    public function index(Request $request): View
    {
        $escuelaFilter = request('escuela-filter');
        $nombreFilter = request('nombre-filter');

        $asignaturas = Asignatura::when($escuelaFilter, function ($query, $escuelaFilter) {
                return $query->where('id_escuela', $escuelaFilter);
            })
            ->when($nombreFilter, function ($query, $nombreFilter) {
                return $query->where('nombre', 'like', "%$nombreFilter%");
            })
            ->paginate(10)->appends($request->query());
        $escuelas = Escuela::all()->pluck('nombre', 'id');
        return view('mantenimientos.asignatura.index', compact('asignaturas', 'escuelas'))->with('message', [
            'type' => 'success',
            'content' => 'La asignatura se ha creado exitosamente.'
        ]);
    }

    public function create(): View
    {
        return view('asignatura.create')->with('message', [
            'type' => 'info',
            'content' => 'Bienvenido al mantenimiento de asignatura.'
        ]);
    }


    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_escuela' => 'required|exists:escuelas,id',
            'nombre' => 'required|max:50|unique:asignaturas,nombre',
            'activo' => 'required|boolean',
        ], [
            'id_escuela.required' => 'El campo de escuela es obligatorio.',
            'id_escuela.exists' => 'La escuela seleccionada no existe en nuestra base de datos.',
            'nombre.required' => 'El nombre de la asignatura es obligatorio.',
            'nombre.max' => 'El nombre de la asignatura no debe exceder los 50 caracteres.',
            'nombre.unique' => 'El nombre de la asignatura ya existe. Por favor, elige otro nombre.',
            'activo.required' => 'El campo de estado activo es obligatorio.',
            'activo.boolean' => 'El campo de estado activo debe ser verdadero o falso.',
        ]);

        Asignatura::create($request->all());
        return redirect()->route('asignatura.index')
            ->with('message', [
                'type' => 'success',
                'content' => 'La asignatura se ha creado exitosamente.'
            ]);
    }


    public function show(string $id): View
    {
        $asignatura = Asignatura::findOrFail($id);
        return view('asignatura.show', compact('asignatura'))->with('message', [
            'type' => 'success',
            'content' => 'La asignatura se ha creado exitosamente.'
        ]);
    }


    public function edit(string $id): View
    {
        $asignatura = Asignatura::findOrFail($id);
        return view('asignatura.edit', compact('asignatura'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $asignatura = Asignatura::findOrFail($id);

             $nombreRule = 'required|max:50';
        if ($asignatura->nombre !== $request->nombre) {
            $nombreRule .= '|unique:asignaturas,nombre';
        }

        // Validamos los datos
        $request->validate([
            'id_escuela' => 'required|exists:escuelas,id',
            'nombre' => $nombreRule,
            'activo' => 'required|boolean',
        ], [
            'id_escuela.required' => 'El campo de escuela es obligatorio.',
            'id_escuela.exists' => 'La escuela seleccionada no existe en nuestra base de datos.',
            'nombre.required' => 'El nombre de la asignatura es obligatorio.',
            'nombre.max' => 'El nombre de la asignatura no debe exceder los 50 caracteres.',
            'nombre.unique' => 'El nombre de la asignatura ya existe. Por favor, elige otro nombre.',
            'activo.required' => 'El campo de estado activo es obligatorio.',
            'activo.boolean' => 'El campo de estado activo debe ser verdadero o falso.',
        ]);


        $asignatura->update($request->all());

        return redirect()->route('asignatura.index')->with('message', [
            'type' => 'success',
            'content' => 'La asignatura se ha actualizado exitosamente.'
        ]);
    }


    public function destroy(string $id): RedirectResponse
    {
        $asignatura = Asignatura::findOrFail($id);
        $asignatura->delete();
        return redirect()->route('asignatura.index')->with('message', [
            'type' => 'success',
            'content' => 'La asignatura se ha eliminado exitosamente.'
        ]);
    }

    public function toggleActivo(Asignatura $asignatura): RedirectResponse
    {
        $asignatura->activo = !$asignatura->activo;
        $asignatura->save();
        return redirect()->route('asignatura.index');
    }
}
