<?php

namespace App\Models\Actividades;

use App\Models\General\Modalidad;
use App\Models\Mantenimientos\TipoActividad;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;

    protected $table = 'actividades';

    protected $fillable = [
        'descripcion',
        'activo',
        'id_tipo_actividad',
    ];

    public function tipoActividad()
    {
        return $this->belongsTo(TipoActividad::class, 'id_tipo_actividad');
    }

    public function modalidad()
    {
        return $this->belongsTo(Modalidad::class, 'id_modalidad');
    }
}
