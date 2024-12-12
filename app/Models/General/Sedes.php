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
        $this->attributes['nombre'] = mb_strtoupper($value, 'utf-8');
    }

    public function setDireccionAttribute($value)
    {
        $this->attributes['direccion'] = mb_strtoupper($value, 'utf-8');
    }
}
