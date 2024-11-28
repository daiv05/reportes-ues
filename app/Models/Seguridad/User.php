<?php

namespace App\Models\Seguridad;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Registro\Persona;
use App\Models\Reportes\Reporte;
use App\Models\rhu\EmpleadoPuesto;
use App\Models\Mantenimientos\Escuela;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Models\Audit;



class User extends Authenticatable implements Auditable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable,\OwenIt\Auditing\Auditable;


    protected $fillable = [
        'carnet',
        'email',
        'password',
        'id_persona',
        'activo',
        'id_escuela',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function setCarnetAttribute($value)
    {
        $this->attributes['carnet'] = strtoupper($value);
    }
    public function persona() : BelongsTo
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    public function empleadosPuestos() : HasMany
    {
        return $this->hasMany(EmpleadoPuesto::class, 'id_usuario');
    }

    public function reportes() : HasMany
    {
        return $this->hasMany(Reporte::class, 'id_usuario_reporta');
    }

    public function escuela(): BelongsTo
    {
        return $this->belongsTo(Escuela::class, 'id_escuela'); // Asegúrate de que el modelo Escuela esté correctamente importado
    }
}
