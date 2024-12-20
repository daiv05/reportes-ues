<?php

namespace App\Models\Reportes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class ReporteBien extends Model implements Auditable
{
    use HasFactory,\OwenIt\Auditing\Auditable;
    
    protected $table = 'reporte_bienes';

    protected $fillable = [
        'id_bien',
        'id_reporte'
    ];

    public function bien() : BelongsTo
    {
        return $this->belongsTo(Bien::class, 'id_bien');
    }

    public function reporte() : BelongsTo
    {
        return $this->belongsTo(Reporte::class, 'id_reporte');
    }
}
