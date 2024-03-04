<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguimientoSemanal extends Model
{
    use HasFactory;
    protected $table = 'seguimiento_semanal'; 
    protected $primaryKey = 'id_seguimiento_semanal'; 
    public $timestamps = false;

    protected $fillable = [ 'archivo_seguimiento',
                            'aprobado',
                            'id_pps'];
}
