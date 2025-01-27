<?php

namespace App\Http\Controllers\Seguridad\Auth;

use App\Enums\RolesEnum;
use App\Http\Controllers\Controller;
use App\Mail\VerifyEmail;
use App\Models\Mantenimientos\Escuela;
use App\Models\Registro\Persona;
use App\Models\Seguridad\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use IvanoMatteo\LaravelDeviceTracking\Facades\DeviceTracker;
use IvanoMatteo\LaravelDeviceTracking\Models\Device;
use OwenIt\Auditing\Models\Audit;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        $escuelas = Escuela::where('activo', 1)->get();
        return view('seguridad.auth.register', ['escuelas' => $escuelas]);
    }

    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'carnet' => 'required|string|min:3|max:20|unique:users|regex:/^(?!.*[._])?[a-zA-Z0-9](?:[a-zA-Z0-9._]{2,18}[a-zA-Z0-9])?$/',
            'nombre' => 'required|string|max:100|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]+$/',
            'apellido' => 'required|string|max:100|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]+$/',
            'fecha_nacimiento' => ['required', 'date_format:d/m/Y'],
            'escuela' => ['required', 'exists:' . Escuela::class . ',id'],
            'telefono' => 'required|string|max:15|regex:/^\+?(\d{1,4})?[-.\s]?(\(?\d{2,4}\)?)?[-.\s]?\d{3,4}[-.\s]?\d{4}$/',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class, 'regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ._%+-]+@ues\.edu\.sv$/'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'nombre.regex' => 'El campo nombre solo puede contener letras y espacios.',
            'apellido.regex' => 'El campo apellido solo puede contener letras y espacios.',
            'telefono.regex' => 'El campo teléfono no tiene un formato válido.',
            'carnet.regex' => 'El campo carnet no tiene un formato válido.',
            'carnet.unique' => 'El carnet ya está en uso.',
            'carnet.min' => 'El carnet debe tener al menos 3 caracteres.',
            'carnet.max' => 'El carnet no debe tener más de 20 caracteres.',
            'nombre.max' => 'El campo nombre no debe tener más de 100 caracteres.',
            'email.regex' => 'El correo electrónico debe ser institucional (@ues.edu.sv).',
            'fecha_nacimiento.date_format' => 'El campo fecha de nacimiento no tiene un formato válido.',
            'fecha_nacimiento.required' => 'El campo fecha de nacimiento es obligatorio.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.required' => 'El campo contraseña es obligatorio.',
        ]);
        $request->merge([
            'fecha_nacimiento' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('fecha_nacimiento'))->format('Y-m-d')
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
            'id_escuela' => $request->escuela,
            'es_estudiante' => true,
        ]);

        $user->assignRole(RolesEnum::USUARIO->value);

        if ($user) {
            event(new Registered($user));

            Audit::create([
                'user_id' => $user->id,
                'event' => 'user_registered',
                'auditable_type' => 'App\Models\Seguridad\User',
                'auditable_id' => $user->id,
                'old_values' => [],
                'new_values' => $user->getAttributes(),
                'url' => request()->url(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
            ]);

            Auth::login($user);

            DeviceTracker::detectFindAndUpdate();
            DeviceTracker::flagCurrentAsVerified();

            return redirect()->route('verificacion-email.comprobacion');
        } else {
            Session::flash('message', [
                'type' => 'error',
                'content' => 'Ocurrió un error inesperado, por favor vuelva a intentar'
            ]);
            return redirect()->back();
        }
    }
}
