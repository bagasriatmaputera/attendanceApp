<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class attendanceHistory extends Model
{
    protected $table = "attendance_history";
    protected $fillable = [
        'employee_id',
        'attendance_id',
        'date_attendance',
        'attendance_type',
        'description',
    ];

    public function employee()
    {
        return $this->belongsTo(employee::class, 'employee_id');
    }

    public function attendance()
    {
        return $this->belongsTo(attendance::class, 'attendance_id');
    }
}
