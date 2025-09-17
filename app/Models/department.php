<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    protected $fillable = [
        'department_name',
        'max_clock_in_time',
        'max_clock_out_time',
    ];

    public function employee()
    {
        return $this->hasMany(employee::class);
    }
}
