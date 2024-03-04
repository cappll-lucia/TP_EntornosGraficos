<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlandeTrabajo extends Model
{
    use HasFactory;
    protected $table = 'plan_de_trabajo'; 
    protected $primaryKey = 'id_plan_de_trabajo'; 
    public $timestamps = false;

    protected $fillable = [ 'id_pps',
                            'archivo_plan',
                            'aprobado'];

}
