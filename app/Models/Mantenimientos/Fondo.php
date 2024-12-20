<?php

namespace App\Models\Mantenimientos;

use App\Models\Reportes\RecursoReporte;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Fondo extends Model implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

    protected $table = 'fondos';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] =strtoupper(strtr($value, 'áéíóú', 'ÁÉÍÓÚ'));
    }
    public function recursosReportes() : HasMany
    {
        return $this->hasMany(RecursoReporte::class, 'id_fondo');
    }
}
