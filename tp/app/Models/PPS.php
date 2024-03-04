<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPS extends Model
{
    use HasFactory;
    protected $table = 'pps'; 
    protected $primaryKey = 'id_pps'; 
    public $timestamps = false;

    protected $fillable = [ 'fecha_inicio',
                            'fecha_fin',
                            'terminada',
                            'observacion',
                            'descripcion',
                            'aprobada',
                            'id_alumno',
                            'id_responsable',
                            'id_docente'];
}
