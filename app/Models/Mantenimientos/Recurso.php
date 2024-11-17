<?php

namespace App\Models\Mantenimientos;

use App\Models\Reportes\RecursoReporte;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Recurso extends Model implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

    protected $table = 'recursos';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    public function recursosReportes() : HasMany
    {
        return $this->hasMany(RecursoReporte::class, 'id_recurso');
    }
}
