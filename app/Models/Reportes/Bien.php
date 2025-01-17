<?php

namespace App\Models\Reportes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class Bien extends Model implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

    protected $table = 'bienes';

    protected $fillable = [
        'id_tipo_bien',
        'nombre',
        'descripcion',
        'codigo',
        'activo',
    ];

    public function tipoBien() : BelongsTo
    {
        return $this->belongsTo(TipoBien::class, 'id_tipo_bien');
    }
    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] =strtoupper(strtr($value, 'áéíóú', 'ÁÉÍÓÚ'));
    }
}
