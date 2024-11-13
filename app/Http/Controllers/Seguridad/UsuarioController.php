<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Models\Registro\Persona;
use App\Models\rhu\EmpleadoPuesto;
use App\Models\rhu\Puesto;
use App\Models\Seguridad\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

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
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'fecha_nacimiento' => 'required',
            'telefono' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'carnet' => 'required|string|max:20',
            'roles' => 'nullable|string', // Roles como cadena separada por comas
            'puesto' => 'required|exists:puestos,id', // Validar que puesto existe en la tabla puestos
        ]);

        $request->merge([
            'fecha_nacimiento' => \Carbon\Carbon::createFromFormat('m/d/Y', $request->input('fecha_nacimiento'))->format('Y-m-d')
        ]);

        try {

            DB::beginTransaction();

            $persona = Persona::create([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'telefono' => $request->telefono,
            ]);

            // Crear el usuario con una contraseña predeterminada
            $usuario = User::create([
                'email' => $request->input('email'),
                'carnet' => $request->input('carnet'),
                'activo' => $request->has('activo'),
                'password' => bcrypt('password123'), // O cualquier otra contraseña que quieras asignar
                'id_persona' => $persona->id, // Asignar persona_id al usuario
            ]);

            EmpleadoPuesto::create([
                'id_usuario' => $usuario->id,
                'id_puesto' => $request->input('puesto'),
            ]);

            // Si hay roles, convertir la cadena de IDs a nombres de roles
            if ($request->filled('roles')) {
                $roles = Role::whereIn('id', explode(',', $request->roles))->pluck('name')->toArray();
                $usuario->syncRoles($roles);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('message', [
                'type' => 'danger',
                'content' => 'Ocurrió un error al crear el usuario. Por favor, inténtelo de nuevo.',
            ]);
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


        $user->update([
            'email' => $request->email,
            'carnet' => $request->carnet,
            'activo' => $request->has('activo'),
        ]);

       // dd($request->roles);
        // Convertir IDs de roles a nombres de roles
        $roles = Role::whereIn('id', explode(',', $request->roles))->pluck('name')->toArray();

        // Sincronizar roles
        $user->syncRoles($roles);

        return redirect()->route('usuarios.index')->with('message', [
            'type' => 'success',
            'content' => 'Usuario actulizado y roles asignados correctamente.',
        ]);
    }




    public function destroy(string $id)
    {

    }

    public function create(Request $request): View
    {
        // Obtener los roles disponibles
        $roles = Role::all();
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $idEntidad = $request->input('entidad');

        $entidades = [];
        $entidadesBackup = \App\Models\rhu\Entidades::all();
        foreach ($entidadesBackup as $entidad) {
            $entidades[$entidad->id] = $entidad->nombre;
        }
        $puestos = Puesto::all()->groupBy('id_entidad')->map(function ($puestos) {
            return $puestos->pluck('nombre', 'id');
        });

        return view('seguridad.usuarios.create', compact('roles', 'entidades', 'puestos'));
    }



    public function show(string $id)
    {

        $user = User::with('empleadosPuestos.puesto.entidad')->findOrFail($id);
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
