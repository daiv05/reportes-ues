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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

class Reporte extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $table = 'reportes';

    protected $appends = [
        'estado_ultimo_historial',
        'relacion_usuario'
    ];

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

    public function reporteBienes(): HasMany
    {
        return $this->hasMany(ReporteBien::class, 'id_reporte');
    }

    public function getEstadoUltimoHistorialAttribute()
    {
        if ($this->accionesReporte == null) {
            return null;
        } else {
            return DB::selectOne(
                'SELECT estado.id, estado.nombre FROM historial_acciones_reportes
                INNER JOIN estados AS estado ON historial_acciones_reportes.id_estado = estado.id
                WHERE historial_acciones_reportes.id_acciones_reporte = ?
                ORDER BY historial_acciones_reportes.created_at DESC
                LIMIT 1',
                [$this->accionesReporte->id]
            );
        }
    }

    public function getRelacionUsuarioAttribute()
    {
        $idUsuario = Auth::user()->id;
        $relaciones = [
            "creador" => false,
            "supervisor" => false,
            "empleado" => false,
        ];
        if ($this->id_usuario_reporta == $idUsuario) {
            $relaciones["creador"] = true;
        }
        $userSupervisor = $this->accionesReporte()->with('usuarioSupervisor')->first();
        if (isset($userSupervisor) && $userSupervisor->usuarioSupervisor->id == $idUsuario) {
            $relaciones["supervisor"] = true;
        }
        $empAcciones = $this->empleadosAcciones()
            ->with('empleadoPuesto')
            ->get()
            ->pluck('empleadoPuesto.usuario.id');
        if ($empAcciones->contains($idUsuario)) {
            $relaciones["empleado"] = true;
        }
        return $relaciones;
    }
}
