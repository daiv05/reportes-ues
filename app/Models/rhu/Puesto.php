<?php

namespace App\Models\rhu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\rhu\Entidades;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Puesto extends Model implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

    protected $table = 'puestos';

    protected $fillable = [
        'id_entidad',
        'nombre',
        'activo',
    ];


    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = mb_strtoupper($value, 'utf-8');
    }
    /**
     * Relación con el modelo Entidades.
     * Un puesto pertenece a una entidad.
     */
    public function entidad()
    {
        return $this->belongsTo(Entidades::class, 'id_entidad');
    }

    public function empleadosPuestos() : HasMany
    {
        return $this->hasMany(EmpleadoPuesto::class, 'id_puesto');
    }
}
