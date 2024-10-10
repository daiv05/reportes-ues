<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sedes extends Model
{
    use HasFactory;

    protected $table = 'sedes';
    
    protected $fillable = ['nombre', 'direccion', 'activo'];
}
