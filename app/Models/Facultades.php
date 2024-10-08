<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facultades extends Model
{
    use HasFactory;

    protected $table = 'facultades';
    protected $fillable = ['nombre', 'activo', 'id_sede'];

    public function sedes()
    {
        return $this->belongsTo(Sedes::class, 'id_sede');
    }

    public function escuelas()
    {
        return $this->hasMany(Escuela::class, 'id_facultad');
    }

}
