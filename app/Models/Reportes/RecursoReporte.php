<?php

namespace App\Models\Reportes;

use App\Models\Mantenimientos\Fondo;
use App\Models\Mantenimientos\Recurso;
use App\Models\Mantenimientos\UnidadMedida;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class RecursoReporte extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $table = 'recursos_reportes';

    protected $fillable = [
        'cantidad',
        'comentario',
        'id_historial_acciones_reporte',
        'id_recurso',
        'id_fondo'
    ];

    public function historialAccionesReporte(): BelongsTo
    {
        return $this->belongsTo(HistorialAccionesReporte::class, 'id_historial_acciones_reporte');
    }

    public function recurso(): BelongsTo
    {
        return $this->belongsTo(Recurso::class, 'id_recurso');
    }

    public function fondo(): BelongsTo
    {
        return $this->belongsTo(Fondo::class, 'id_fondo');
    }

    public function unidadMedida(): BelongsTo
    {
        return $this->belongsTo(UnidadMedida::class, 'id_unidad_medida');
    }
}
