<?php

namespace App\Models\Reportes;

use App\Models\rhu\EmpleadoPuesto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmpleadoAccion extends Model
{
    use HasFactory;

    protected $table = 'empleados_acciones';

    protected $fillable = [
        'id_reporte',
        'id_empleado_puesto'
    ];

    public function reporte() : BelongsTo
    {
        return $this->belongsTo(Reporte::class, 'id_reporte');
    }

    public function empleadoPuesto() : BelongsTo
    {
        return $this->belongsTo(EmpleadoPuesto::class, 'id_empleado_puesto');
    }
}
