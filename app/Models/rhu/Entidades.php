<?php

namespace App\Models\rhu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Entidades extends Model implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

    protected $table = 'entidades';

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
        'id_entidad',
        'jerarquia'   
    ];


    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper($value);
    }
    public function padre()
    {
        return $this->belongsTo(Entidades::class, 'id_entidad', 'id');
    }
}

