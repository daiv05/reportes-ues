<?php

namespace App\Models\rhu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

class Entidades extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $table = 'entidades';

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
        'id_entidad',
        'jerarquia'
    ];


    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper(strtr($value, 'áéíóú', 'ÁÉÍÓÚ'));
    }

    public function padre()
    {
        return $this->belongsTo(Entidades::class, 'id_entidad', 'id');
    }

    public function hijos()
    {
        return $this->hasMany(Entidades::class, 'id_entidad', 'id');
    }

    public function getDeepHijosAttribute()
    {
        $entidadesHijas = DB::select("
            WITH RECURSIVE entidades_hijas AS (
                SELECT * FROM entidades WHERE id = ?
                UNION ALL
                SELECT e.* FROM entidades e
                INNER JOIN entidades_hijas eh ON e.id_entidad = eh.id
            )
            SELECT * FROM entidades_hijas
        ", [$this->id]);

        return $entidadesHijas;
    }
}
