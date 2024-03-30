<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPS extends Model
{
    use HasFactory;

    protected $table = 'pps'; 
    protected $primaryKey = 'id'; 
    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'responsible_id',
        'teacher_id',
        'start_date',
        'finish_date',
        'is_finished',
        'is_approved',
        'description',
        'observation',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

}
