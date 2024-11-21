<?php

namespace App\Http\Controllers\Seguridad\Auth;

use App\Http\Controllers\Controller;
use App\Models\Mantenimientos\Escuela;
use App\Models\Registro\Persona;
use App\Models\Seguridad\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use OwenIt\Auditing\Models\Audit;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $escuelas = Escuela::all();
        return view('seguridad.auth.register', ['escuelas' => $escuelas]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Convertir la fecha antes de la validación
        $request->merge([
            'fecha_nacimiento' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('fecha_nacimiento'))->format('Y-m-d')
        ]);

        $request->validate([
            'carnet' => ['required', 'string', 'max:10'],
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'fecha_nacimiento' => ['required'],
            'telefono' => ['required', 'string', 'max:15'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $persona = Persona::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'telefono' => $request->telefono,
        ]);

        $user = User::create([
            'carnet' => $request->carnet,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_persona' => $persona->id,
        ]);

        event(new Registered($user));

        // Auditoría del registro de usuario
        Audit::create([
            'user_id' => $user->id, // ID del usuario registrado
            'event' => 'user_registered', // Nombre del evento
            'auditable_type' => 'App\Models\Seguridad\User', // Tipo de modelo
            'auditable_id' => $user->id, // ID del usuario
            'old_values' => [],
            'new_values' => $user->getAttributes(), // Atributos nuevos del usuario
            'url' => request()->url(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
        ]);
        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
