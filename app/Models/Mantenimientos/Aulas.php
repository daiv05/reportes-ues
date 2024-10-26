<?php

namespace App\Models\Mantenimientos;

use App\Models\General\Facultades;
use App\Models\Reportes\Reporte;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Aulas extends Model
{
    use HasFactory;

    protected $table = 'aulas';
    
    protected $fillable = ['nombre', 'activo', 'id_facultad'];

    public function facultades()
    {
        return $this->belongsTo(Facultades::class, 'id_facultad');
    }

    public function reportes() : HasMany
    {
        return $this->hasMany(Reporte::class, 'id_aula');
    }
}
