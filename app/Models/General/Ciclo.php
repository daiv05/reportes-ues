<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciclo extends Model
{
    use HasFactory;

    protected $table = 'ciclos';

    protected $fillable = [
        'anio',
        'id_tipo_ciclo',
        'fecha_inicio',
        'fecha_fin',
        'activo',
    ];

    public function tipoCiclo()
    {
        return $this->belongsTo(TipoCiclo::class, 'id_tipo_ciclo');
    }
}
