<?php

namespace App\Models\Reportes;

use App\Models\CategoriaReporte;
use App\Models\rhu\Entidades;
use App\Models\Seguridad\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class AccionesReporte extends Model implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

    protected $fillable = [
        'id_reporte',
        'id_usuario_administracion',
        'id_entidad_asignada',
        'id_usuario_supervisor',
        'id_categoria_reporte',
        'comentario',
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
        return $this->belongsTo(Entidades::class, 'id_entidad_asignada');
    }

    public function usuarioSupervisor() : BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario_supervisor');
    }

    public function historialAccionesReporte() : HasMany
    {
        return $this->hasMany(HistorialAccionesReporte::class, 'id_acciones_reporte');
    }

    public function categoriaReporte(): BelongsTo
    {
        return $this->belongsTo(CategoriaReporte::class, 'id_categoria_reporte');
    }
}
