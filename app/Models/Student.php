<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'marks' => 'array',
        'attendance_rate' => 'integer',
        'fee_amount' => 'decimal:2',
        'fee_due_date' => 'date',
        'paid_date' => 'date',
        'dob' => 'date',
    ];

    public function attendanceRecords()
    {
        return $this->hasMany(AttendanceRecord::class);
    }
}
