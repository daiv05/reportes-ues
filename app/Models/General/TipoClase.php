<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoClase extends Model
{
    use HasFactory;
    protected $table = 'tipo_clases';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    public function clases()
    {
        //return $this->hasMany(Clase::class, 'id_tipo_clase');
    }
}
