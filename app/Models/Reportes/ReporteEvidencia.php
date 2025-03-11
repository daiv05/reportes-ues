<?php

namespace App\Models\Reportes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteEvidencia extends Model
{
    use HasFactory;

    protected $table = 'reportes_evidencia';

    protected $fillable = [
        'id_reporte',
        'ruta',
    ];

    public function reporte()
    {
        return $this->belongsTo(Reporte::class, 'id_reporte');
    }
}
