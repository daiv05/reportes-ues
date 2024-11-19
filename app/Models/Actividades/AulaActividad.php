<?php

namespace App\Models;

use App\Models\Actividades\Actividad;
use App\Models\Mantenimientos\Aulas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AulaActividad extends Model  implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

    protected $table = 'aula_actividades';

    protected $fillable = [
        'id_aula',
        'id_actividad',
    ];

    public function aula()
    {
        return $this->belongsTo(Aulas::class, 'id_aula');
    }

    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'id_actividad');
    }
}
