<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCiclo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'activo',
    ];

    public function ciclos()
    {
        return $this->hasMany(Ciclo::class, 'id_tipo_evento');
    }
}
