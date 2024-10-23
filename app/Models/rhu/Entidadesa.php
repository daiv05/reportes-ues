<?php

namespace App\Models\Mantenimientos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $table = 'departamentos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
        'id_departamento', // Asegúrate de incluir este campo
        'jerarquia'        // Asegúrate de incluir este campo
    ];

    public function padre()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento', 'id');
    }
}

