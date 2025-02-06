<?php

namespace App\Models\Mantenimientos;

use App\Models\General\Facultades;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Escuela extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = ['id_facultad', 'nombre', 'activo'];

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper(strtr($value, 'áéíóúñ', 'ÁÉÍÓÚÑ'));

    }
    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class, 'id_escuela');
    }

    public function facultad()
    {
        return $this->belongsTo(Facultades::class, 'id_facultad');
    }
}
