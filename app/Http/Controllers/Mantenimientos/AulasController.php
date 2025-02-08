<?php

namespace App\Http\Controllers\Mantenimientos;

use App\Enums\GeneralEnum;
use App\Http\Controllers\Controller;
use App\Models\General\Facultades;
use App\Models\Mantenimientos\Aulas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\Mantenimiento\StoreAulaRequest;
use App\Imports\AulaImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AulasController extends Controller
{
    public function index(Request $request): View
    {
        $nombreFilter = request('nombre-filter');
        $aulas = Aulas::when($nombreFilter, function ($query, $nombreFilter) {
            return $query->where('nombre', 'like', "%$nombreFilter%");
        })
            ->paginate(GeneralEnum::PAGINACION->value)->appends($request->query());
        $facultades = Facultades::where('activo', true)->get();
        return view('mantenimientos.aulas.index', compact('aulas', 'facultades'));
    }

    public function create(): View
    {
        return view('aulas.create');
    }

    public function store(StoreAulaRequest  $request): RedirectResponse
    {
        Aulas::create($request->all());
        return redirect()->route('aulas.index')->with('message', [
            'type' => 'success',
            'content' => 'Aula creada exitosamente'
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

            $import = new AulaImport();
            Excel::import($import, $request->file('excel_file'));

            DB::commit();

            return redirect()->route('aulas.index')->with('message', [
                'type' => 'success',
                'content' => 'Los locales se han importado exitosamente.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('aulas.index')->with('message', [
                'type' => 'error',
                'content' => 'Ha ocurrido un error al importar los locales: ' . $e->getMessage()
            ]);
        }
    }


    public function show(string $id): View
    {
        $aula = Aulas::findOrFail($id);
        return view('aulas.show', compact('aula'));
    }


    public function edit(string $id): View
    {
        $aula = Aulas::findOrFail($id);
        return view('aulas.edit', compact('aula'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|max:30|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ]+$/',
            'id_facultad' => 'required|exists:facultades,id',
            'activo' => 'required',
        ], [
            'nombre.regex' => 'El nombre solo puede contener letras y números.',
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no debe exceder los 30 caracteres.',
            'id_facultad.required' => 'La facultad es obligatoria.',
            'id_facultad.exists' => 'La facultad seleccionada no existe en nuestra base de datos.',
            'activo.required' => 'El campo de estado activo es obligatorio.',
        ]);

        $aula = Aulas::findOrFail($id);
        if ($aula->nombre !== $request->input('nombre')) {
            $nombre = $request->input('nombre');
            $idFacultad = $request->input('id_facultad');
            $existingAula = Aulas::where('nombre', $nombre)
                ->where('id_facultad', $idFacultad)
                ->where('id', '!=', $id)
                ->first();
            if ($existingAula) {
                return redirect()->route('aulas.index')->with('message', [
                    'type' => 'warning',
                    'content' => 'Ya existe un aula con este nombre en la facultad seleccionada.'
                ]);
            }
        }
        $aula->update($request->only(['nombre', 'id_facultad', 'activo']));
        return redirect()->route('aulas.index')->with('message', [
            'type' => 'success',
            'content' => 'Aula actualizada exitosamente'
        ]);
    }



    public function destroy(string $id): RedirectResponse
    {
        $aula = Aulas::findOrFail($id);
        $aula->delete();
        return redirect()->route('aulas.index');
    }

    public function toggleActivo(Aulas $aula): RedirectResponse
    {
        $aula->activo = !$aula->activo;
        $aula->save();
        return redirect()->route('aulas.index');
    }
}
