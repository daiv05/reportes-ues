<?php

namespace App\Models\Reportes;

use App\Models\General\EstadoBien;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Bien extends Model implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

    protected $table = 'bienes';

    protected $fillable = [
        'id_tipo_bien',
        'id_estado_bien',
        'nombre',
        'descripcion',
        'codigo',
        'activo',
    ];

    public function tipoBien() : BelongsTo
    {
        return $this->belongsTo(TipoBien::class, 'id_tipo_bien');
    }

    public function estadoBien() : BelongsTo
    {
        return $this->belongsTo(EstadoBien::class, 'id_estado_bien');
    }

    public function reporteBien() : HasMany
    {
        return $this->hasMany(ReporteBien::class, 'id_bien');
    }

    // Obtener todos los reportes de un bien
    public function reportes()
    {
        return $this->belongsToMany(Reporte::class, 'reporte_bienes', 'id_bien', 'id_reporte');
    }

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] =strtoupper(strtr($value, 'áéíóúñ', 'ÁÉÍÓÚÑ'));
    }
}
