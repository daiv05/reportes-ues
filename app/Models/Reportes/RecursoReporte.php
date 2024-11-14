<?php

namespace App\Models\Reportes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

 class RecursoReporte extends Model implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

    protected $table = 'recursos_reportes';

    protected $fillable = [
        'nombre',
        'costo',
        'id_historial_acciones_reporte'
    ];

    public function historialAccionesReporte() : BelongsTo
    {
        return $this->belongsTo(HistorialAccionesReporte::class, 'id_historial_acciones_reporte');
    }
}
