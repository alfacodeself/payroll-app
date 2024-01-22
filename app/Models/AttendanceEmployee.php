<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Status;
use App\Casts\TimeCast;

class AttendanceEmployee extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'payment_status' => Status::class,
        'paid_at' => 'date',
        'attendance_time' => TimeCast::class,
    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
    public function employeeJob()
    {
        return $this->belongsTo(EmployeeJob::class);
    }
    public function payrollDetails()
    {
        return $this->hasMany(PayrollDetail::class);
    }
}
