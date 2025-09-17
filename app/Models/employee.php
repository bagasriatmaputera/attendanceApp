<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'employee_id',
        'department_id',
        'name',
        'email',
        'address'
    ];

    public function department()
    {
        return $this->belongsTo(department::class);
    }
    public function attendanceHistory()
    {
        return $this->hasMany(attendanceHistory::class);
    }
    public function attendance()
    {
        return $this->hasMany(attendance::class);
    }
}
