<?php

namespace App\Models\Mantenimientos;

use App\Models\Reportes\RecursoReporte;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class UnidadMedida extends Model implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

    protected $table = 'unidades_medida';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper(strtr($value, 'áéíóúñ', 'ÁÉÍÓÚÑ'));
    }

    public function recursosReportes() : HasMany
    {
        return $this->hasMany(RecursoReporte::class, 'id_recurso');
    }
}
