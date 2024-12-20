<?php

namespace App\Models\Mantenimientos;

use App\Models\General\Facultades;
use App\Models\Reportes\Reporte;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Aulas extends Model  implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

    protected $table = 'aulas';

    protected $fillable = ['nombre', 'activo', 'id_facultad'];

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper(strtr($value, 'áéíóú', 'ÁÉÍÓÚ'));
    }
    public function facultad()
    {
        return $this->belongsTo(Facultades::class, 'id_facultad');
    }

    public function reportes() : HasMany
    {
        return $this->hasMany(Reporte::class, 'id_aula');
    }

}
