<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeeklyTracking extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'weekly_tracking';

    protected $fillable = [
        'pps_id',
        'file_path',
        'is_accepted',
        'is_editable',
    ];

    public function PPS()
    {
        return $this->belongsTo(PPS::class, 'pps_id');
    }
}
