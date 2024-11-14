<?php

namespace App\Models;

use App\Models\Actividades\Actividad;
use App\Models\Mantenimientos\Asignatura;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;


class AsignaturaActividad extends Model  implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

    protected $table = 'asignatura_actividades';

    protected $fillable = [
        'id_asignatura',
        'id_actividad',
    ];

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class, 'id_asignatura');
    }

    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'id_actividad');
    }
}
