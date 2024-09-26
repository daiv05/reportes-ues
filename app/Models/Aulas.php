<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aulas extends Model
{
    use HasFactory;

    protected $table = 'aulas';
    protected $fillable = ['nombre', 'activo', 'id_facultad'];

    public function facultades()
    {
        return $this->belongsTo(Facultades::class, 'id_facultad');
    }
}
