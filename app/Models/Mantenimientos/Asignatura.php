<?php

namespace App\Models\Mantenimientos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Asignatura extends Model  implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

    protected $fillable = ['id_escuela', 'nombre', 'nombre_completo', 'activo'];

    public function setNombreAttribute($value)
    {
        $value = strtoupper($value);
        $this->attributes['nombre'] = strtr($value, 'áéíóú', 'ÁÉÍÓÚ');
        $this->attributes['nombre_completo'] = strtr($value, 'áéíóú', 'ÁÉÍÓÚ');
    }
    public function escuela()
    {
        return $this->belongsTo(Escuela::class, 'id_escuela');
    }

}
