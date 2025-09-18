<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'attendance_id',
        'clock_in',
        'clock_out',
    ];

    public function employee()
    {
        return $this->belongsTo(employee::class,'employee_id','employee_id');
    }
    public function attendanceHistory()
    {
        return $this->hasMany(employee::class,'employee_id');
    }
}
