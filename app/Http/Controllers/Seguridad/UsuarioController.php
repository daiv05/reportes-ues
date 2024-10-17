<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Models\Seguridad\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    public function index(): View
    {
        $usuarios = User::with('roles')->paginate(10);
        return view('seguridad.usuarios.index', compact('usuarios'));
    }


    public function update(Request $request, string $id)
    {

    }

    public function destroy(string $id)
    {

    }

    public function toggleActivo(User $aula)
    {

    }
}
