<?php

namespace App\Http\Controllers\Mantenimientos;

use App\Http\Controllers\Controller;
use App\Models\Mantenimientos\Departamento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DepartamentoController extends Controller
{
    public function index(): View
    {
        // Departamentos paginados
        $departamentos = Departamento::paginate(5);

        // Lista jerárquica de departamentos para el select
        $departamentosLista = $this->getHierarchicalDepartamentos();
        //dd($departamentosLista);

        return view('mantenimientos.departamentos.index', compact('departamentos', 'departamentosLista'));
    }
    private function getHierarchicalDepartamentos($parentId = null, $parentName = '')
    {
        // Obtener departamentos cuyo id_departamento (padre) coincide con $parentId
        $departamentos = Departamento::where('id_departamento', $parentId)
            ->orderBy('id') // Ordenar para mantener el orden adecuado
            ->get();

        $result = collect(); // Utilizar una colección para facilitar el manejo de los datos
        foreach ($departamentos as $departamento) {
            // Construir el nombre jerárquico completo del departamento
            $nombreCompleto = $parentName ? $parentName . ' --> ' . $departamento->nombre : $departamento->nombre;

            // Actualizar el nombre del departamento con el nombre completo
            $departamento->nombre = $nombreCompleto;
            $result->push($departamento);

            // Añadir los hijos de manera recursiva, acumulando los nombres de los padres
            $nuevoParentName = $nombreCompleto;
            $result = $result->merge($this->getHierarchicalDepartamentos($departamento->id, $nuevoParentName));
        }

        return $result;
    }

    public function store(Request $request): RedirectResponse
    {
        // Validación de los campos del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|unique:departamentos|max:50',
            'descripcion' => 'required|max:100',
            'id_departamento' => 'nullable|exists:departamentos,id', // Asegura que el departamento padre exista si se selecciona
            'activo' => 'required|boolean',
        ]);

        // Determinar la jerarquía según el departamento padre
        if (empty($validatedData['id_departamento'])) {
            $validatedData['jerarquia'] = 0; // Si no hay departamento padre, es un departamento raíz con jerarquía 0
        } else {
            // Obtener el departamento padre para calcular la jerarquía
            $departamentoPadre = Departamento::find($validatedData['id_departamento']);
            $validatedData['jerarquia'] = $departamentoPadre->jerarquia + 1;
        }

        // Crear el departamento con los datos validados y la jerarquía calculada
        // dd($validatedData);
        Departamento::create($validatedData);

        // Redirección a la vista de departamentos con un mensaje de éxito (opcional)
        return redirect()->route('departamentos.index')->with('success', 'Departamento creado exitosamente');
    }


    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'nombre' => ['required', Rule::unique('departamentos')->ignore($id), 'max:50'],
            'descripcion' => 'required|max:50',
            'activo' => 'required|boolean',
            'id_departamento' => 'nullable|exists:departamentos,id', // Validar que el departamento padre exista si es seleccionado
        ]);

        $departamento = Departamento::findOrFail($id);

        // Actualizar los datos del departamento
        $departamento->nombre = $request->nombre;
        $departamento->descripcion = $request->descripcion;
        $departamento->activo = $request->activo;

        // Ajustar jerarquía y departamento padre si se selecciona uno
        if ($request->filled('id_departamento')) {
            $departamentoPadre = Departamento::findOrFail($request->id_departamento);
            $departamento->id_departamento = $request->id_departamento;
            $departamento->jerarquia = $departamentoPadre->jerarquia + 1;
        } else {
            $departamento->id_departamento = null;
            $departamento->jerarquia = 0;
        }

        $departamento->save();

        return redirect()->route('departamentos.index')->with('success', 'Departamento actualizado exitosamente');
    }

    public function destroy(string $id): RedirectResponse
    {
        $departamento = Departamento::findOrFail($id);
        $departamento->delete();
        return redirect()->route('departamentos.index');
    }

    public function toggleActivo(Departamento $departamento): RedirectResponse
    {
        $departamento->activo = !$departamento->activo;
        $departamento->save();
        return redirect()->route('departamentos.index');
    }
}
