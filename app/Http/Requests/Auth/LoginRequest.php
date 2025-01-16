<?php

namespace App\Http\Requests\Auth;

use App\Models\Seguridad\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'carnet' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();
        $message = '';

        // Verificar que el usuario esté activo y que tenga asignado un rol
        if (Auth::attemptWhen([
            'carnet' => $this->string('carnet'),
            'password' => $this->string('password'),
        ], function (User $user) use (&$message) {
            // Usuario activo
            $validUser = true;
            if ($user->activo === 0) {
                $message = 'El usuario no se encuentra activo dentro del sistema';
                $validUser = false;
            }
            // Posee al menos un rol activo
            $validRole = 0;

            $user->roles->each(function ($rol) use (&$validRole) {
                if ($rol->activo === 1) {
                    $validRole++;
                }
            });
            if (! $validRole) {
                $message = 'El usuario no posee un rol activo dentro del sistema';
                $validUser = false;
            }
            if (! $user->es_estudiante) {
                // Si es empleado: posee al menos un puesto activo
                $validPuesto = 0;
                $user->empleadosPuestos->each(function ($empPuesto) use (&$validPuesto) {
                    if ($empPuesto->activo === 1) {
                        $validPuesto++;
                    }
                });
                if (! $validPuesto) {
                    $message = 'El usuario no posee un puesto activo dentro del sistema';
                    $validUser = false;
                }
            } else {
                // Si es estudiante: la escuela a la que pertenece está activa
                if ($user->escuela->activo === 0) {
                    $message = 'La escuela a la que pertenece el usuario no se encuentra activa dentro del sistema';
                    $validUser = false;
                }
            }
            return $validUser;
        }, $this->boolean('remember'))) {
            RateLimiter::clear($this->throttleKey());
        } else {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'error' => $message ?: trans('auth.failed'),
            ]);
        }
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'carnet' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('carnet')) . '|' . $this->ip());
    }
}
