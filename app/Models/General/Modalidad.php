<?php

namespace App\Models\General;

use App\Models\Actividades\Actividad;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Modalidad extends Model  implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

    protected $table = 'modalidades';

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
        return $this->hasMany(Actividad::class, 'id_modalidad');
    }
}
