<?php

namespace App\Http\Controllers\rhu;

use App\Http\Controllers\Controller;
use App\Models\rhu\Entidades;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EntidadesController extends Controller
{
    public function index(): View
    {
        // entidades paginados
        $entidades = Entidades::paginate(5);

        // Lista jerárquica de entidades para el select
        $entidadesLista = $this->getHierarchicalEntidades();
        //dd($entidades);

        return view('rhu.entidades.index', compact('entidades', 'entidadesLista'));
    }
    private function getHierarchicalEntidades($parentId = null, $parentName = '')
    {
        // Obtener entidades cuyo id_entidad (padre) coincide con $parentId
        $entidades = Entidades::where('id_entidad', $parentId)
            ->orderBy('id') // Ordenar para mantener el orden adecuado
            ->get();

        $result = collect(); // Utilizar una colección para facilitar el manejo de los datos
        foreach ($entidades as $entidad) {
            // Construir el nombre jerárquico completo del departamento
            $nombreCompleto = $parentName ? $parentName . ' --> ' . $entidad->nombre : $entidad->nombre;

            // Actualizar el nombre del departamento con el nombre completo
            $entidad->nombre = $nombreCompleto;
            $result->push($entidad);

            // Añadir los hijos de manera recursiva, acumulando los nombres de los padres
            $nuevoParentName = $nombreCompleto;
            $result = $result->merge($this->getHierarchicalEntidades($entidad->id, $nuevoParentName));
        }

        return $result;
    }

    public function store(Request $request): RedirectResponse
    {
        // Validación de los campos del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|unique:entidades|max:50',
            'descripcion' => 'required|max:100',
            'id_entidad' => 'nullable|exists:entidades,id', // Asegura que el departamento padre exista si se selecciona
            'activo' => 'required|boolean',
        ]);

        // Determinar la jerarquía según el departamento padre
        if (empty($validatedData['id_entidad'])) {
            $validatedData['jerarquia'] = 0; // Si no hay departamento padre, es un departamento raíz con jerarquía 0
        } else {
            // Obtener el departamento padre para calcular la jerarquía
            $departamentoPadre = Entidades::find($validatedData['id_entidad']);
            $validatedData['jerarquia'] = $departamentoPadre->jerarquia + 1;
        }

        // Crear el departamento con los datos validados y la jerarquía calculada
        // dd($validatedData);
        \App\Models\rhu\Entidadesa::create($validatedData);

        // Redirección a la vista de departamentos con un mensaje de éxito (opcional)
        return redirect()->route('entidades.index')->with('success', 'Entidadesa creado exitosamente');
    }


    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'nombre' => ['required', Rule::unique('entidades')->ignore($id), 'max:50'],
            'descripcion' => 'required|max:50',
            'activo' => 'required|boolean',
            'id_entidad' => 'nullable|exists:entidades,id', // Validar que el departamento padre exista si es seleccionado
        ]);

        $entidad = Entidades::findOrFail($id);

        // Actualizar los datos del departamento
        $entidad->nombre = $request->nombre;
        $entidad->descripcion = $request->descripcion;
        $entidad->activo = $request->activo;

        // Ajustar jerarquía y entidad padre si se selecciona uno
        if ($request->filled('id_departamento')) {
            $entidadPadre = Entidades::findOrFail($request->id_entidad);
            $entidad->id_entidad = $request->id_entidad;
            $entidad->jerarquia = $entidadPadre->jerarquia + 1;
        } else {
            $entidad->id_entidad = null;
            $entidad->jerarquia = 0;
        }

        $entidad->save();

        return redirect()->route('entidades.index')->with('success', 'Entidadesa actualizado exitosamente');
    }

    public function destroy(string $id): RedirectResponse
    {
        $entidad = Entidades::findOrFail($id);
        $entidad->delete();
        return redirect()->route('entidades.index');
    }

    public function toggleActivo(Entidades $entidad): RedirectResponse
    {
        $entidad->activo = !$entidad->activo;
        $entidad->save();
        return redirect()->route('entidades.index');
    }
}
