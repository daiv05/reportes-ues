<?php

namespace App\Models\Seguridad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Role extends Model  implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;

    // Definir los campos que pueden ser asignados en masa
    protected $fillable = ['name', 'activo'];

    // Puedes agregar relaciones si el rol tiene alguna
}
