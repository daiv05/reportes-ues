<?php

namespace App\Models;

use App\Models\Reportes\Reporte;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaReporte extends Model
{
    use HasFactory;

    protected $table = 'categoria_reportes';

    protected $fillable = [
        'nombre',
        'descripcion',
        'icono',
        'tiempo_promedio',
        'peso'
    ];

    public function reportes()
    {
        return $this->hasMany(Reporte::class, 'id_categoria_reporte');
    }
}
