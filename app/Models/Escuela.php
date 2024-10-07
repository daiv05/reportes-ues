<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escuela extends Model
{
    use HasFactory;

    protected $fillable = ['id_facultad', 'nombre', 'activo'];

    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class, 'id_escuela');
    }
}
