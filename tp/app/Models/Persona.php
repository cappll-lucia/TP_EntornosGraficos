<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'persona'; 
    protected $primaryKey = 'id'; 
    public $timestamps = false;

    protected $fillable = [ 'nombre',
                            'apellido',
                            'id_usuario'];

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'id_usuario');
    }

}
