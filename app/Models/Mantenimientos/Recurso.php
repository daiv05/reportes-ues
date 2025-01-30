<?php

namespace App\Models\Mantenimientos;

use App\Models\Reportes\RecursoReporte;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Normalizer;
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
        $this->attributes['nombre'] = strtoupper(strtr($value, 'áéíóú', 'ÁÉÍÓÚ'));
    }

    public function getNombreUnaccentAttribute()
    {
        $nombre_normalizado = Normalizer::normalize($this->nombre, Normalizer::FORM_D);
        return preg_replace('/\pM/u', '', $nombre_normalizado);
    }

    public function recursosReportes() : HasMany
    {
        return $this->hasMany(RecursoReporte::class, 'id_recurso');
    }
}
