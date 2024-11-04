<?php

namespace App\Models\Seguridad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Definir los campos que pueden ser asignados en masa
    protected $fillable = ['name', 'activo'];

    // Puedes agregar relaciones si el rol tiene alguna
}
