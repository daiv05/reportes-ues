<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Facultades;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DepartamentoController extends Controller
{
    public function index(): View
    {
        $departamentos = Departamento::paginate(5);
        return view('mantenimientos.departamentos.index', compact('departamentos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|unique:departamentos|max:50',
            'descripcion' => 'required|max:50',
        ]);
        Departamento::create($request->all());
        return redirect()->route('departamentos.index');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'nombre' => ['required', Rule::unique('departamentos')->ignore($id), 'max:50'],
            'descripcion' => 'required|max:50',
        ]);

        $departamento = Departamento::findOrFail($id);
        $departamento->update($request->all());
        return redirect()->route('departamentos.index');
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
