<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEvento extends Model
{
    use HasFactory;
    protected $table = 'tipo_eventos';

    protected $fillable = [
        'nombre',
        'activo',
    ];

//     public function eventos()
//     {
//         return $this->hasMany(Evento::class, 'id_tipo_evento');
//     }
}
