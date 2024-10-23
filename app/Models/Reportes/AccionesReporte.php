<?php

namespace App\Models\Reportes;

use App\Models\Mantenimientos\Departamento;
use App\Models\Seguridad\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccionesReporte extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_reporte',
        'id_usuario_administracion',
        'id_entidad_asignada',
        'id_usuario_supervisor',
        'comentario_encargado',
        'fecha_asignacion',
        'fecha_inicio',
        'hora_inicio',
        'fecha_finalizacion',
        'hora_finalizacion',
    ];

    public function reporte() : BelongsTo
    {
        return $this->belongsTo(Reporte::class, 'id_reporte');
    }

    public function usuarioAdministracion() : BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario_administracion');
    }

    public function entidadAsignada() : BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'id_entidad_asignada');
    }

    public function usuarioSupervisor() : BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario_supervisor');
    }

    public function historialAccionesReporte() : HasMany
    {
        return $this->hasMany(HistorialAccionesReporte::class, 'id_acciones_reporte');
    }
}
