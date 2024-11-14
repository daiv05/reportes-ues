<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mantenimientos\Ciclo;
use OwenIt\Auditing\Contracts\Auditable;

class TipoCiclo extends Model  implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

    protected $table = 'tipos_ciclos';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    public function ciclos()
    {
        return $this->hasMany(Ciclo::class, 'id_tipo_ciclo');
    }
}
