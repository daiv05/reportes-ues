<?php

namespace App\Models\Reportes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estado extends Model
{
    use HasFactory;

    protected $table = 'estados';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    public function historialAccionesReporte() : HasMany
    {
        return $this->hasMany(HistorialAccionesReporte::class, 'id_estado');
    }
}
