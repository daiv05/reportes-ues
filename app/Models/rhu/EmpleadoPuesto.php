<?php

namespace App\Models\rhu;

use App\Models\Reportes\EmpleadoAccion;
use App\Models\Reportes\HistorialAccionesReporte;
use App\Models\Seguridad\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmpleadoPuesto extends Model
{
    use HasFactory;

    protected $table = 'empleados_puestos';

    protected $fillable = [
        'id_usuario',
        'id_puesto',
        'descripcion',
        'activo',
    ];

    public function puesto() : BelongsTo
    {
        return $this->belongsTo(Puesto::class, 'id_puesto');
    }

    public function usuario() : BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function historialAccionesReporte() : HasMany
    {
        return $this->hasMany(HistorialAccionesReporte::class, 'id_empleado_puesto');
    }

    public function empleadosAcciones() : HasMany
    {
        return $this->hasMany(EmpleadoAccion::class, 'id_empleado_puesto');
    }
}
