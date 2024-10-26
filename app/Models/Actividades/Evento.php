<?php

namespace App\Models;

use App\Models\Actividades\Actividad;
use App\Models\General\TipoEvento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';

    protected $fillable = [
        'descripcion',
        'id_actividad',
        'id_tipo_evento',
        'fecha',
        'cantidad_asistentes',
        'comentarios',
    ];

    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'id_actividad');
    }

    public function tipoEvento()
    {
        return $this->belongsTo(TipoEvento::class, 'id_tipo_evento');
    }
}
