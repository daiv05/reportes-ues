<?php

namespace App\Models\General;

use App\Models\Mantenimientos\Escuela;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Facultades extends Model  implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

    protected $table = 'facultades';

    protected $fillable = ['nombre', 'activo', 'id_sede'];

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper($value);
    }
    public function sedes()
    {
        return $this->belongsTo(Sedes::class, 'id_sede');
    }

    public function escuelas()
    {
        return $this->hasMany(Escuela::class, 'id_facultad');
    }

}
