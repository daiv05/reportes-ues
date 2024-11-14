<?php

namespace App\Models\Mantenimientos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\General\TipoCiclo;
use OwenIt\Auditing\Contracts\Auditable;

class Ciclo extends Model implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

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
