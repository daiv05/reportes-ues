<?php

namespace App\Models\rhu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entidades extends Model
{
    use HasFactory;

    protected $table = 'entidades';

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
        'id_entidad', // Asegúrate de incluir este campo
        'jerarquia'        // Asegúrate de incluir este campo
    ];

    public function padre()
    {
        return $this->belongsTo(Entidades::class, 'id_entidad', 'id');
    }
}

