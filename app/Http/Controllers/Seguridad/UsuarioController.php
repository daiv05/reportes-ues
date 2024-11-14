<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Models\Seguridad\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Models\Audit;

class UsuarioController extends Controller
{
    public function index(): View
    {
        $usuarios = User::with('roles')->paginate(10);
        return view('seguridad.usuarios.index', compact('usuarios'));
    }
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'carnet' => 'required|string|max:20',
            'roles' => 'nullable|string', // Roles como cadena separada por comas
            'persona_id' => 'required|exists:personas,id', // Validar que persona_id existe en la tabla personas
        ]);

        // Crear el usuario con una contraseña predeterminada
        $user = User::create([
            'email' => $request->input('email'),
            'carnet' => $request->input('carnet'),
            'activo' => $request->has('activo'),
            'password' => bcrypt('password123'), // O cualquier otra contraseña que quieras asignar
            'id_persona' => $request->input('persona_id'), // Asignar persona_id al usuario
        ]);

        // Si hay roles, convertir la cadena de IDs a nombres de roles
        if ($request->filled('roles')) {
            $roles = Role::whereIn('id', explode(',', $request->roles))->pluck('name')->toArray();
            $user->syncRoles($roles);
        }

        // Redireccionar con mensaje de éxito
        return redirect()->route('usuarios.index')->with('message', [
            'type' => 'success',
            'content' => 'Usuario creado y roles asignados correctamente.',
        ]);
    }





    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validar los datos de entrada
        $request->validate([
            'email' => 'required|email|max:255',
            'carnet' => 'required|string|max:20',
            'roles' => 'nullable|string', // Validar los roles (cadena separada por comas)
        ]);

        // Guardar los datos actualizados del usuario
        $user->update([
            'email' => $request->email,
            'carnet' => $request->carnet,
            'activo' => $request->has('activo'),
        ]);

        // Obtener los roles actuales y los nuevos roles
        $currentRoles = $user->roles->pluck('name')->toArray(); // Roles actuales antes de la sincronización
        $newRoles = Role::whereIn('id', explode(',', $request->roles))->pluck('name')->toArray(); // Nuevos roles a asignar

        // Sincronizar roles
        $user->syncRoles($newRoles);

        // Registrar la auditoría de los cambios en los roles
        Audit::create([
            'user_id' => auth()->id(), // ID del usuario que realizó la actualización
            'event' => 'updated_roles',
            'auditable_type' => 'App\Models\User',  // Tipo de entidad auditada (User)
            'auditable_id' => $user->id,  // ID del usuario que se actualiza
            'old_values' => ['roles' => $currentRoles],  // Roles anteriores
            'new_values' => ['roles' => $newRoles],  // Nuevos roles
            'url' => request()->url(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
        ]);

        return redirect()->route('usuarios.index')->with('message', [
            'type' => 'success',
            'content' => 'Usuario actualizado y roles asignados correctamente.',
        ]);
    }





    public function destroy(string $id)
    {

    }

    public function create(): View
    {
        // Obtener los roles disponibles
        $roles = Role::all();

        // Obtener personas que aún no tienen usuario
        $personasSinUsuario = DB::table('personas')
            ->leftJoin('users', 'personas.id', '=', 'users.id_persona')
            ->whereNull('users.id_persona')
            ->select('personas.*') // Ajusta los campos que necesites
            ->get();

        return view('seguridad.usuarios.create', compact('roles', 'personasSinUsuario'))
            ->with('message', [
                'type' => 'info',
                'content' => 'Bienvenido al mantenimiento de usuarios.'
            ]);
    }



    public function show(string $id)
    {

        $user = User::findOrFail($id);
        return view('seguridad.usuarios.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        // Obtener todos los roles disponibles
        $roles = Role::all();

        return view('seguridad.usuarios.edit', compact('user', 'roles'));
    }

    public function toggleActivo(User $aula)
    {

    }
}
