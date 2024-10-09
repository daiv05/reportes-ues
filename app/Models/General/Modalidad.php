<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modalidad extends Model
{
    use HasFactory;
    protected $table = 'modalidades';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'id_modalidad');
    }
}
