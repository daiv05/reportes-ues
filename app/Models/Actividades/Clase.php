<?php

namespace App\Models;

use App\Models\Actividades\Actividad;
use App\Models\General\TipoClase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    use HasFactory;

    protected $table = 'clases';

    protected $fillable = [
        'dias_actividad',
        'id_actividad',
        'id_tipo_clase',
        'numero_grupo'
    ];

    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'id_actividad');
    }

    public function tipoClase()
    {
        return $this->belongsTo(TipoClase::class, 'id_tipo_clase');
    }
}
