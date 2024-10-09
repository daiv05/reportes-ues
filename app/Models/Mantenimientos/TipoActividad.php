<?php

namespace App\Models\Mantenimientos;

use App\Models\Actividades\Actividad;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoActividad extends Model
{
    use HasFactory;
    protected $table = 'tipo_actividades';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'id_tipo_actividad');
    }
}
