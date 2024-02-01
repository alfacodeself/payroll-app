<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Status;
use App\Casts\TimeCast;

class Attendance extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'status' => Status::class,
        // 'date' => 'date',
        'close_at' => TimeCast::class,
    ];
    public function scopeByUnpaidEmployeeJobId($query, $employeeJobId)
    {
        return $query->with('attendanceEmployees.employeeJob')->whereHas('attendanceEmployees', function ($q) use ($employeeJobId) {
            $q->where('employee_job_id', $employeeJobId)->where('payment_status', Status::UNPAID);
        });
    }
    public function totalIncomePaidEmployee(): int
    {
        $query = $this->attendanceEmployees->where('payment_status', Status::PAID);
        $total = 0;
        foreach ($query as $q) {
            $total += $q->showIncome();
        }
        return $total;
    }
    public function totalIncomeUnpaidEmployee()
    {
        $query = $this->attendanceEmployees->where('payment_status', Status::UNPAID);
        $total = 0;
        foreach ($query as $q) {
            $total += $q->showIncome();
        }
        return $total;
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function attendanceEmployees()
    {
        return $this->hasMany(AttendanceEmployee::class);
    }
}
