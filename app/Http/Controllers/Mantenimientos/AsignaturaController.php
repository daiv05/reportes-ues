<?php

namespace App\Http\Controllers\Mantenimientos;

use App\Enums\GeneralEnum;
use App\Http\Controllers\Controller;
use App\Imports\AsignaturaImport;
use App\Models\Mantenimientos\Asignatura;
use App\Models\Mantenimientos\Escuela;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AsignaturaController extends Controller
{
    public function index(Request $request): View
    {
        $escuelaFilter = request('escuela-filter');
        $nombreFilter = request('nombre-filter');
        $nombreCompletoFilter = request('nombre-completo-filter');

        $asignaturas = Asignatura::when($escuelaFilter, function ($query, $escuelaFilter) {
            return $query->where('id_escuela', $escuelaFilter);
        })
            ->when($nombreFilter, function ($query, $nombreFilter) {
                return $query->where('nombre', 'like', "%$nombreFilter%");
            })
            ->when($nombreCompletoFilter, function ($query, $nombreCompletoFilter) {
                return $query->where('nombre_completo', 'like', "%$nombreCompletoFilter%");
            })
            ->paginate(GeneralEnum::PAGINACION->value)->appends($request->query());
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

            $import = new AsignaturaImport();
            \Excel::import($import, $request->file('excel_file'));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            if ($e->getCode() === '23000') { // Código SQL para violaciones de unicidad
                // Extraer el valor duplicado
                preg_match("/Duplicate entry '(.+)' for key/", $e->getMessage(), $valueMatch);
                $failedValue = $valueMatch[1] ?? 'desconocido';

                // Extraer la clave única que falló
                preg_match("/for key '(.+)'/", $e->getMessage(), $keyMatch);
                $failedKey = $keyMatch[1] ?? 'desconocido';


                \Log::error('Error al importar asignaturas: ' . $e->getMessage());
                return redirect()->route('asignatura.index')->with('message', [
                    'type' => 'error',
                ]);
            } else {
                return redirect()->route('asignatura.index')->with('message', [
                    'type' => 'error',
                    'content' => 'Ha ocurrido un error al importar los datos. Por favor, verifica que el archivo sea correcto. '
                ]);
            }
        }

        return redirect()->route('asignatura.index')->with('message', [
            'type' => 'success',
            'content' => 'Los datos se han importado exitosamente.'
        ]);
    }


    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_escuela' => 'required|exists:escuelas,id',
            'nombre' => 'required|max:10|unique:asignaturas,nombre|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ]$/',
            'nombre_completo' => 'required|max:50|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ ]$/',
            'activo' => 'required|boolean',
        ], [
            'id_escuela.required' => 'El campo de escuela es obligatorio.',
            'id_escuela.exists' => 'La escuela seleccionada no existe en nuestra base de datos.',
            'nombre.required' => 'El código de la asignatura es obligatorio.',
            'nombre.max' => 'El código de la asignatura no debe exceder los 10 caracteres.',
            'nombre.unique' => 'El código de la asignatura ya existe. Por favor, elige otro código.',
            'nombre.regex' => 'El código de la asignatura solo puede contener letras y números.',
            'nombre_completo.required' => 'El nombre de la asignatura es obligatorio.',
            'nombre_completo.max' => 'El nombre de la asignatura no debe exceder los 50 caracteres.',
            'nombre_completo.regex' => 'El nombre de la asignatura solo puede contener letras, números y espacios.',
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

        $nombreRule = 'required|max:10|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ]$/';
        if ($asignatura->nombre !== $request->nombre) {
            $nombreRule .= '|unique:asignaturas,nombre';
        }

        // Validamos los datos
        $request->validate([
            'id_escuela' => 'required|exists:escuelas,id',
            'nombre' => $nombreRule,
            'nombre_completo' => 'required|max:50|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ ]$/',
            'activo' => 'required|boolean',
        ], [
            'id_escuela.required' => 'El campo de escuela es obligatorio.',
            'id_escuela.exists' => 'La escuela seleccionada no existe en nuestra base de datos.',
            'nombre.required' => 'El código de la asignatura es obligatorio.',
            'nombre.max' => 'El código de la asignatura no debe exceder los 10 caracteres.',
            'nombre.unique' => 'El código de la asignatura ya existe. Por favor, elige otro nombre.',
            'nombre.regex' => 'El código de la asignatura solo puede contener letras y números.',
            'nombre_completo.required' => 'El nombre de la asignatura es obligatorio.',
            'nombre_completo.max' => 'El nombre de la asignatura no debe exceder los 50 caracteres.',
            'nombre_completo.regex' => 'El nombre de la asignatura solo puede contener letras, números y espacios.',
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
