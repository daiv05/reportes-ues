<?php

namespace App\Models\General;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Actividades\Evento;

class TipoEvento extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $table = 'tipo_eventos';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] =strtoupper(strtr($value, 'áéíóúñ', 'ÁÉÍÓÚÑ'));
    }
    public function eventos()
    {
        return $this->hasMany(Evento::class, 'id_tipo_evento');
    }
}
