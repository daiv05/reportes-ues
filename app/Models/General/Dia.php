<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Dia extends Model  implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

    protected $table = 'dias';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = mb_strtoupper($value, 'utf-8');
    }
}
