<?php

namespace App\Models\Mantenimientos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Asignatura extends Model  implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

    protected $fillable = ['id_escuela', 'nombre', 'activo'];

    public function escuela()
    {
        return $this->belongsTo(Escuela::class, 'id_escuela');
    }

}
