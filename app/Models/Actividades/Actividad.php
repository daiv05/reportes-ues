<?php

namespace App\Models\Actividades;

use App\Models\General\Modalidad;
use App\Models\Mantenimientos\Asignatura;
use App\Models\Mantenimientos\Aulas;
use App\Models\Mantenimientos\TipoActividad;
use App\Models\Reportes\Reporte;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;

class Actividad extends Model  implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

    protected $table = 'actividades';

    protected $fillable = [
        'id_modalidad',
        'id_ciclo',
        'hora_inicio',
        'hora_fin',
        'activo',
    ];

    public function modalidad()
    {
        return $this->belongsTo(Modalidad::class, 'id_modalidad');
    }

    public function reportes() : HasMany
    {
        return $this->hasMany(Reporte::class, 'id_actividad');
    }

    public function aulas()
    {
        return $this->belongsToMany(Aulas::class, 'aula_actividades', 'id_actividad', 'id_aula');
    }

    public function asignaturas()
    {
        return $this->belongsToMany(Asignatura::class, 'asignatura_actividades', 'id_actividad', 'id_asignatura');
    }

    public function clase() : HasOne
    {
        return $this->hasOne(Clase::class, 'id_actividad');
    }

    public function evento() : HasOne
    {
        return $this->hasOne(Evento::class, 'id_actividad');
    }
}
