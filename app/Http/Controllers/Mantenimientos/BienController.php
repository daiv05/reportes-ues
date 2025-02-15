<?php

namespace App\Http\Controllers\Mantenimientos;

use App\Enums\EstadosBienEnum;
use App\Enums\GeneralEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\BienImport;
use App\Models\General\EstadoBien;
use App\Models\Reportes\Bien;
use App\Models\Reportes\TipoBien;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class BienController extends Controller
{
    public function index(Request $request): View
    {
        $filtroNombre = $request->input('nombre-filter');
        $filtroTipo = $request->input('tipo-bien-filter');
        $filtroEstado = $request->input('estado-bien-filter');
        $filtroCodigo = $request->input('codigo-filter');

        $bienes = Bien::when($filtroTipo, function ($query, $filtroTipo) {
            return $query->where('id_tipo_bien', $filtroTipo);
        })->when($filtroNombre, function ($query, $filtroNombre) {
            return $query->where('nombre', 'like', '%' . $filtroNombre . '%');
        })->when($filtroEstado, function ($query, $filtroEstado) {
            return $query->where('id_estado_bien', $filtroEstado);
        })->when($filtroCodigo, function ($query, $filtroCodigo) {
            return $query->where('codigo', 'like', '%' . $filtroCodigo . '%');
        })->paginate(GeneralEnum::PAGINACION->value)->appends($request->query());

        $tiposBienes = TipoBien::where('activo', 1)->get();
        $estadoBienes = EstadoBien::where('activo', 1)->get();

        return view('mantenimientos.bienes.index', compact('tiposBienes', 'bienes', 'estadoBienes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|max:50|unique:bienes,nombre',
            'id_tipo_bien' => 'required|exists:tipos_bienes,id',
            'id_estado_bien' => 'required|exists:estados_bienes,id',
            'descripcion' => 'required|max:250',
            'codigo' => 'required|max:50|unique:bienes,codigo',
            'activo' => 'nullable|boolean',
        ], [
            'nombre.required' => 'El nombre del bien es requerido',
            'nombre.max' => 'El nombre debe tener un máximo de 50 caracteres',
            'nombre.unique' => 'Ya existe un bien con ese nombre',
            'id_tipo_bien.required' => 'Debe específicar el tipo de bien',
            'id_tipo_bien.exists' => 'El tipo de bien no existe',
            'id_estado_bien.required' => 'Debe específicar el estado del bien',
            'id_estado_bien.exists' => 'El estado especificado no existe',
            'descripcion.required' => 'La descripción es requerida',
            'descripcion.max' => 'La descripción debe tener un máximo de 250 caracteres',
            'codigo.required' => 'El código del bien es requerido',
            'codigo.max' => 'El código debe tener un máximo de 50 caracteres',
            'codigo.unique' => 'Ya existe un bien con ese código',
        ]);

        Bien::create($request->all());
        return redirect()->route('bienes.index')->with('message', [
            'type' => 'success',
            'content' => 'El bien se ha creado exitosamente.'
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

            $import = new BienImport();
            Excel::import($import, $request->file('excel_file'));

            DB::commit();

            return redirect()->route('bienes.index')->with('message', [
                'type' => 'success',
                'content' => 'Los bienes se han importado exitosamente.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al importar bienes: ' . $e);
            DB::rollBack();
            return redirect()->route('bienes.index')->with('message', [
                'type' => 'error',
                'content' => 'Ha ocurrido un error al importar los bienes: ' . $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|max:50|unique:bienes,nombre,' . $id,
            'id_tipo_bien' => 'required|exists:tipos_bienes,id',
            'id_estado_bien' => 'required|exists:estados_bienes,id',
            'descripcion' => 'required|max:250',
            'codigo' => 'required|max:50|unique:bienes,codigo,' . $id,
            'activo' => 'nullable|boolean',
        ], [
            'nombre.required' => 'El nombre del bien es requerido',
            'nombre.max' => 'El nombre debe tener un máximo de 50 caracteres',
            'nombre.unique' => 'Ya existe un bien con ese nombre',
            'id_tipo_bien.required' => 'Debe específicar el tipo de bien',
            'id_tipo_bien.exists' => 'El tipo de bien no existe',
            'id_estado_bien.required' => 'Debe específicar el estado del bien',
            'id_estado_bien.exists' => 'El estado especificado no existe',
            'descripcion.required' => 'La descripción es requerida',
            'descripcion.max' => 'La descripción debe tener un máximo de 250 caracteres',
            'codigo.required' => 'El código del bien es requerido',
            'codigo.max' => 'El código debe tener un máximo de 50 caracteres',
            'codigo.unique' => 'Ya existe un bien con ese código',
        ]);

        $bien = Bien::findOrFail($id);
        $bien->update($request->all());
        return redirect()->route('bienes.index')->with('message', [
            'type' => 'success',
            'content' => 'El bien se ha actualizado exitosamente.'
        ]);
    }

    public function findByNameOrCode(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'search' => 'nullable|string|min:1|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ\- ]+$/',
            'id_tipo_bien' => 'nullable|integer|exists:tipos_bienes,id',
        ], [
            'search.regex' => 'El campo de búsqueda solo puede contener letras, números, espacios y guiones',
            'id_tipo_bien.exists' => 'El tipo de bien no existe',
        ]);

        if ($validated->fails()) {
            error_log($validated->errors());
            return response()->json($validated->errors(), 400);
        }

        $query = Bien::query();

        $query->where('activo', 1)->where('id_estado_bien', EstadosBienEnum::ACTIVO->value);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('codigo', 'like', '%' . $request->input('search') . '%');
            });
        }

        if ($request->filled('id_tipo_bien')) {
            $query->where('id_tipo_bien', $request->input('id_tipo_bien'));
        }

        $bienes = $query->get();

        return response()->json($bienes);
    }

    public function detailWithReports(string $id): View
    {
        $bien = Bien::findOrFail($id);
        $reportes = $bien->reportes()->paginate(GeneralEnum::PAGINACION->value);

        return view('mantenimientos.bienes.detail', compact('bien', 'reportes'));
    }
}
