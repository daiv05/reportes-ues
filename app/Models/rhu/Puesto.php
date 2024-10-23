<?php

namespace App\Models\rhu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\rhu\Entidades;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Puesto extends Model
{
    use HasFactory;

    protected $table = 'puestos';

    protected $fillable = [
        'id_departamento',
        'nombre',
        'activo',
    ];

    /**
     * Relación con el modelo Entidadesa.
     * Un puesto pertenece a un departamento.
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
