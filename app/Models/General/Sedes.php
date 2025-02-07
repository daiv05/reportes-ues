<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Sedes extends Model  implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

    protected $table = 'sedes';

    protected $fillable = ['nombre', 'direccion', 'activo'];

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper(strtr($value, 'áéíóúñ', 'ÁÉÍÓÚÑ'));
    }

    public function setDireccionAttribute($value)
    {
        $this->attributes['direccion'] = strtoupper(strtr($value, 'áéíóúñ', 'ÁÉÍÓÚÑ'));
    }
}
