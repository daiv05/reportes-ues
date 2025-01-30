<?php

namespace App\Models\Mantenimientos;

use App\Models\Reportes\RecursoReporte;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Recurso extends Model implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

    protected $table = 'recursos';

    protected $appends = ['nombre_unaccent'];

    protected $fillable = [
        'nombre',
        'activo',
    ];

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper(strtr($value, 'áéíóúñ', 'ÁÉÍÓÚÑ'));
    }

    public function getNombreUnaccentAttribute()
    {
        $originales = array('Á', 'É', 'Í', 'Ó', 'Ú');
        $modificadas = array('A', 'E', 'I', 'O', 'U');
        $cadena = str_replace($originales, $modificadas, $this->nombre);
        return $cadena;
    }

    public function recursosReportes() : HasMany
    {
        return $this->hasMany(RecursoReporte::class, 'id_recurso');
    }
}
