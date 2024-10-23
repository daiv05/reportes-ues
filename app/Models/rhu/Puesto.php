<?php

namespace App\Models\rhu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mantenimientos\Departamento;
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
     * Relación con el modelo Departamento.
     * Un puesto pertenece a un departamento.
     */
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento');
    }

    public function empleadosPuestos() : HasMany
    {
        return $this->hasMany(EmpleadoPuesto::class, 'id_puesto');
    }
}
