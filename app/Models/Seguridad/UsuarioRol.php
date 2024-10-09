<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsuarioRol extends Model
{
    use HasFactory;

    protected $table = 'usuarios_roles';

    protected $fillable = [
        'id_rol',
        'id_usuario'
    ];

    public function rol() : BelongsTo
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }

    public function usuario() : BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
