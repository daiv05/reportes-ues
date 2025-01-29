<?php

namespace App\Http\Controllers\rhu;

use App\Enums\GeneralEnum;
use App\Http\Controllers\Controller;
use App\Models\rhu\Entidades;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EntidadesController extends Controller
{
    public function index(): View
    {
        $nombreFilter = request('nombre-filter');

        // entidades paginados
        $entidades = Entidades::when($nombreFilter, function ($query, $nombreFilter) {
            return $query->where('nombre', 'like', "%$nombreFilter%");
        })
            ->where('activo', true)
            ->paginate(GeneralEnum::PAGINACION->value)->appends(request()->query());

        // Lista jerárquica de entidades para el select
        $entidadesLista = $this->getHierarchicalEntidades();
        //dd($entidades);

        return view('rhu.entidades.index', compact('entidades', 'entidadesLista'));
    }
    private function getHierarchicalEntidades($parentId = null, $parentName = '')
    {
        // Obtener entidades cuyo id_entidad (padre) coincide con $parentId
        $entidades = Entidades::where('id_entidad', $parentId)
            ->where('activo', true)
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
            'nombre' => 'required|unique:entidades|max:50|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ\s]+$/',
            'descripcion' => 'required|max:250',
            'id_entidad' => 'nullable|exists:entidades,id',
            'activo' => 'required|boolean',
        ], [
            'nombre.regex' => 'El nombre solo acepta letras, números y espacios',
            'nombre.unique' => 'El nombre ya está en uso',
            'nombre.max' => 'El nombre debe tener un máximo de 50 caracteres',
            'descripcion.max' => 'La descripción debe tener un máximo de 250 caracteres',
            'id_entidad.exists' => 'La entidad padre seleccionado no existe',
        ]);

        // Determinar la jerarquía según el departamento padre
        if (empty($validatedData['id_entidad'])) {
            $validatedData['jerarquia'] = 0; // Si no hay departamento padre, es un departamento raíz con jerarquía 0
        } else {
            // Obtener el departamento padre para calcular la jerarquía
            $departamentoPadre = Entidades::find($validatedData['id_entidad']);
            $validatedData['jerarquia'] = $departamentoPadre->jerarquia + 1;
        }

        Entidades::create($validatedData);

        // Redirección a la vista de departamentos con un mensaje de éxito (opcional)
        return redirect()->route('entidades.index')->with('message', [
            'type' => 'success',
            'content' => 'Entidad creada exitosamente'
        ]);
    }


    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate(
            [
                'nombre' => ['required', 'regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ\s]+$/',  Rule::unique('entidades')->ignore($id), 'max:50'],
                'descripcion' => 'required|max:250',
                'activo' => 'required|boolean',
                'id_entidad' => 'nullable|exists:entidades,id|not_in:' . $id,
            ],
            [
                'nombre.regex' => 'El nombre solo acepta letras, números y espacios',
                'nombre.unique' => 'El nombre ya está en uso',
                'nombre.max' => 'El nombre debe tener un máximo de 50 caracteres',
                'descripcion.max' => 'La descripción debe tener un máximo de 250 caracteres',
                'id_entidad.exists' => 'La entidad padre seleccionada no existe',
                'id_entidad.not_in' => 'No puedes seleccionar la misma entidad como padre',
            ]
        );
        $entidad = Entidades::findOrFail($id);
        // Ajustar jerarquía y entidad padre si se selecciona uno
        if ($request->filled('id_entidad')) {
            $entidadPadre = Entidades::findOrFail($request->input('id_entidad'));
            // Verificar si se está generando un ciclo
            if ($this->esDescendiente($entidadPadre->id, $entidad->id)) {
                Session::flash('message', [
                    'type' => 'warning',
                    'content' => 'No puedes seleccionar un descendiente como padre'
                ]);
                return back()->withInput();
            }
            $entidad->id_entidad = $entidadPadre->id;
            $entidad->jerarquia = $entidadPadre->jerarquia + 1;
        } else {
            $entidad->id_entidad = null;
            $entidad->jerarquia = 0;
        }

        $entidad->nombre = $request->nombre;
        $entidad->descripcion = $request->descripcion;
        $entidad->activo = $request->activo;
        $entidad->save();

        return redirect()->route('entidades.index')->with('message', [
            'type' => 'success',
            'content' => 'Entidad actualizada exitosamente'
        ]);
    }

    public function destroy(string $id): RedirectResponse
    {
        $entidad = Entidades::findOrFail($id)->where('activo', true);
        $entidad->delete();
        return redirect()->route('entidades.index');
    }

    public function toggleActivo(Entidades $entidad): RedirectResponse
    {
        $entidad->activo = !$entidad->activo;
        $entidad->save();
        return redirect()->route('entidades.index');
    }

    public function esDescendiente($idNuevoPadre, $idEntidad) : bool
    {
        error_log('Nuevo padre: ' . $idNuevoPadre);
        $padre = Entidades::findOrFail($idNuevoPadre);

        while ($padre->id_entidad) {
            error_log('Hijo: ' . $padre->id_entidad);
            if ($padre->id_entidad == $idEntidad) {
                return true;
            }
            $padre = Entidades::find($padre->id_entidad);
        }

        return false;
    }
}
