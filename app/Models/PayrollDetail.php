<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\PayrollType;

class PayrollDetail extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'payroll_type' => PayrollType::class,
    ];
    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }
    public function attendanceEmployee()
    {
        return $this->belongsTo(AttendanceEmployee::class);
    }
}
