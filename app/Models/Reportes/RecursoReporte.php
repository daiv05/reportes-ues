<?php

namespace App\Models\Reportes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecursoReporte extends Model
{
    use HasFactory;

    protected $table = 'recursos_reportes';

    protected $fillable = [
        'nombre',
        'precio',
        'id_historial_acciones_reporte'
    ];

    public function historialAccionesReporte() : BelongsTo
    {
        return $this->belongsTo(HistorialAccionesReporte::class, 'id_historial_acciones_reporte');
    }
}
