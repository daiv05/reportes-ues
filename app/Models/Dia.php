<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dia extends Model
{
    use HasFactory;
    protected $table = 'dia';

    protected $fillable = [
        'nombre',
        'activo',
    ];
}
