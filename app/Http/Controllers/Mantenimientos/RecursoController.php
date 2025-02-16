<?php

namespace App\Http\Controllers\Mantenimientos;

use App\Enums\GeneralEnum;
use App\Http\Controllers\Controller;
use App\Imports\RecursoImport;
use App\Models\Mantenimientos\Recurso;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RecursoController extends Controller
{
    public function index(Request $request): View
    {
        $query = Recurso::query();
        if ($request->has('nombre-filter')) {
            $filtro = $request->input('nombre-filter');
            $query->where('nombre', 'like', '%' . $filtro . '%');
        }
        $recursos = $query->paginate(GeneralEnum::PAGINACION->value)->appends($request->query());
        return view('mantenimientos.recursos.index', compact('recursos'));
    }

    public function create(): View
    {
        return view('mantenimientos.recursos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|max:50|unique:recursos,nombre|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ\s]+$/',
            'activo' => 'nullable|boolean',
        ], [
            'nombre.required' => 'El nombre del recurso es requerido',
            'nombre.regex' => 'El nombre solo acepta letras, números y espacios.',
            'nombre.max' => 'El nombre debe tener un máximo de 50 caracteres',
            'nombre.unique' => 'Ya existe un recurso con ese nombre.',
        ]);
        Recurso::create($request->all());
        return redirect()->route('recursos.index')->with('message', [
            'type' => 'success',
            'content' => 'El recurso se ha creado exitosamente.'
        ]);
    }

    public function importarDatos(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv',
        ], [
            'archivo.required' => 'El archivo es obligatorio.',
            'archivo.mimes' => 'El archivo debe ser de tipo xlsx, xls o cvs.',
        ]);

        try {
            DB::beginTransaction();

            $import = new RecursoImport();
            Excel::import($import, $request->file('excel_file'));

            DB::commit();

            return redirect()->route('recursos.index')->with('message', [
                'type' => 'success',
                'content' => 'Los recursos se han importado exitosamente.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('recursos.index')->with('message', [
                'type' => 'error',
                'content' => 'Ha ocurrido un error al importar los recursos: ' . $e->getMessage()
            ]);
        }
    }

    public function edit(Recurso $recurso): View
    {
        return view('mantenimientos.recursos.edit', compact('recurso'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|max:50|regex:regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ\s]+$/|unique:recursos,nombre,' . $id,
            'activo' => 'nullable|boolean',
        ], [
            'nombre.required' => 'El nombre del recurso es requerido',
            'nombre.max' => 'El nombre debe tener un máximo de 50 caracteres',
            'nombre.regex' => 'El nombre solo acepta letras, números y espacios.',
            'nombre.unique' => 'Ya existe un recurso con ese nombre.',
        ]);

        $recurso = Recurso::findOrFail($id);
        $recurso->update($request->all());
        return redirect()->route('recursos.index')->with('message', [
            'type' => 'success',
            'content' => 'El recurso se ha actualizado exitosamente.'
        ]);
    }
}
