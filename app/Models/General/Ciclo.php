<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciclo extends Model
{
    use HasFactory;

    protected $table = 'ciclos';

    // app/Models/Ciclo.php
protected $fillable = [
    'anio',
    'id_tipo_ciclo',
    'activo',
];


    public function tipoCiclo()
    {
        return $this->belongsTo(TipoCiclo::class, 'id_tipo_ciclo');
    }
}
