<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoClase extends Model
{
    use HasFactory;
    protected $table = 'tipo_clase';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    public function clases()
    {
        //return $this->hasMany(Clase::class, 'id_tipo_clase');
    }
}
