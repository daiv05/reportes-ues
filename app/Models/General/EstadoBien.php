<?php

namespace App\Models\General;

use App\Models\Reportes\Bien;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoBien extends Model
{
    use HasFactory;

    protected $table = 'estados_bienes';

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] =strtoupper(strtr($value, 'áéíóú', 'ÁÉÍÓÚ'));
    }

    public function bienes()
    {
        return $this->hasMany(Bien::class, 'id_estado_bien');
    }
}
