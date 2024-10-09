<?php

namespace App\Models\Mantenimientos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = ['id_escuela', 'nombre', 'activo'];

    public function escuela()
    {
        return $this->belongsTo(Escuela::class, 'id_escuela');
    }

}
