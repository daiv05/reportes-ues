<?php

namespace App\Models\Reportes;

use App\Models\rhu\EmpleadoPuesto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class HistorialAccionesReporte extends Model implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

    protected $table = 'historial_acciones_reportes';

    protected $fillable = [
        'id_acciones_reporte',
        'id_empleado_puesto',
        'id_estado',
        'foto_evidencia',
        'comentario',
        'fecha_actualizacion',
        'hora_actualizacion',
    ];

    public function accionesReporte() : BelongsTo
    {
        return $this->belongsTo(AccionesReporte::class, 'id_acciones_reporte');
    }

    public function empleadoPuesto() : BelongsTo
    {
        return $this->belongsTo(EmpleadoPuesto::class, 'id_empleado_puesto');
    }

    public function estado() : BelongsTo
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }

    public function recursosReportes() : HasMany
    {
        return $this->hasMany(RecursoReporte::class, 'id_historial_acciones_reporte');
    }
}
