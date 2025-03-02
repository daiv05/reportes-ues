<?php

namespace App\Models\Mantenimientos;

use App\Models\Reportes\AccionesReporte;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaReporte extends Model
{
    use HasFactory;

    protected $table = 'categoria_reportes';

    protected $fillable = [
        'nombre',
        'descripcion',
        'unidad_tiempo',
        'tiempo_promedio',
        'activo',
    ];

    public function accionesReportes()
    {
        return $this->hasMany(AccionesReporte::class, 'id_categoria_reporte');
    }
}
