<?php

namespace App\Models\Mantenimientos;

use App\Models\Actividades\Actividad;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TipoActividad extends Model  implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

    protected $table = 'tipo_actividades';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper(strtr($value, 'áéíóú', 'ÁÉÍÓÚ'));
    }
    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'id_tipo_actividad');
    }
}
