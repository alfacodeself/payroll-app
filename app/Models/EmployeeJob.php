<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Status;

class EmployeeJob extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'status' => Status::class,
    ];
    public function scopeByCompany($query, $companyId)
    {
        return $query->with('job.departement.company')->whereHas('job.departement.company', function ($q) use ($companyId) {
            $q->where('id', $companyId);
        });
    }
    public function attendanceEmployees()
    {
        return $this->hasMany(AttendanceEmployee::class);
    }
    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
