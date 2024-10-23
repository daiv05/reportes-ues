<?php

namespace App\Models\Reportes;

use App\Models\Actividades\Actividad;
use App\Models\Mantenimientos\Aulas;
use App\Models\Seguridad\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reporte extends Model
{
    use HasFactory;

    protected $table = 'reportes';

    protected $appends = ['estado_ultimo_historial'];

    protected $fillable = [
        'id_aula',
        'id_actividad',
        'id_usuario_reporta',
        'fecha_reporte',
        'hora_reporte',
        'descripcion',
        'titulo',
        'no_procede',
    ];

    public function aula(): BelongsTo
    {
        return $this->belongsTo(Aulas::class, 'id_aula');
    }

    public function actividad(): BelongsTo
    {
        return $this->belongsTo(Actividad::class, 'id_actividad');
    }

    public function usuarioReporta(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario_reporta');
    }

    public function accionesReporte(): HasOne
    {
        return $this->hasOne(AccionesReporte::class, 'id_reporte');
    }

    public function empleadosAcciones(): HasMany
    {
        return $this->hasMany(EmpleadoAccion::class, 'id_reporte');
    }

    public function getEstadoUltimoHistorialAttribute()
    {
        return $this->accionesReporte()
            ->with(['historialAccionesReporte' => function ($query) {
                $query->orderBy('fecha_actualizacion_seguimiento', 'desc')->first();
            }])
            ->get()
            ->pluck('historialAccionesReporte')
            ->flatten()
            ->sortByDesc('fecha_actualizacion_seguimiento')
            ->first()?->estado;
    }
}
