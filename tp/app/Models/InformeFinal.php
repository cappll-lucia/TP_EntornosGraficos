<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformeFinal extends Model
{
    use HasFactory;
    protected $table = 'informe_final'; 
    protected $primaryKey = 'id_informe_final'; 
    public $timestamps = false;

    protected $fillable = [ 'id_pps',
                            'informe',
                            'aprobado',
                            'observacion'];
}
