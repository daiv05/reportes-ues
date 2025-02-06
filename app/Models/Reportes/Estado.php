<?php

namespace App\Models\Reportes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Estado extends Model implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

    protected $table = 'estados';

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    public function historialAccionesReporte() : HasMany
    {
        return $this->hasMany(HistorialAccionesReporte::class, 'id_estado');
    }
    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] =strtoupper(strtr($value, 'áéíóúñ', 'ÁÉÍÓÚÑ'));
    }
}
