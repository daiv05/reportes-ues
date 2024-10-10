<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Models\Seguridad\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AulasController extends Controller
{
    public function index(): View
    {
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    // public function show(string $id): View
    // {
    //     $usuario = User::findOrFail($id);
    //     return view('usuarios.show', compact('usuario'));
    // }

    // public function edit(string $id): View
    // {
    //     $usuario = User::findOrFail($id);
    //     return view('aulas.edit', compact('aula'));
    // }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required',
            'id_facultad' => 'required|exists:facultades,id',
        ]);
        $usuario = User::findOrFail($id);
        $usuario->update($request->all());
        return redirect()->route('usuario.index');
    }

    public function destroy(string $id): RedirectResponse
    {
        $aula = User::findOrFail($id);
        $aula->delete();
        return redirect()->route('aulas.index');
    }

    public function toggleActivo(User $aula): RedirectResponse
    {
        $aula->activo = !$aula->activo;
        $aula->save();
        return redirect()->route('aulas.index');
    }
}
