<?php

namespace App\Http\Controllers\seguridad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {

        $roles = Role::paginate(5);
        // Retornar la vista y pasar los datos
        return view('seguridad.roles.index', compact('roles'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los campos recibidos
        $request->validate([
            'name' => 'required|unique:roles|max:50',
            'activo' => 'required|boolean', // Validación para el campo activo
        ]);

        // Crear el nuevo rol con los campos validados
        Role::create($request->only(['name', 'activo']));

        // Redirigir al índice de roles con un mensaje de éxito
        return redirect()->route('roles.index')->with('message', [
            'type' => 'success',
            'content' => 'Rol creado exitosamente.',
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', Rule::unique('roles')->ignore($id), 'max:50'],
            'activo' => 'required|boolean',
        ]);

        $role = Role::findOrFail($id);
        $role->update($request->all());
        return redirect()->route('roles.index')->with('message', [
            'type' => 'success',
            'content' => 'Rol actulizado exitosamente.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rol = Role::findOrFail($id);
        $rol->delete();
        return redirect()->route('rol.index');
    }

    public function toggleActivo(role $role): RedirectResponse
    {
        $role->activo = !$role->activo;
        $role->save();
        return redirect()->route('role.index');
    }
}
