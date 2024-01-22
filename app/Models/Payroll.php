<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'paid_at' => 'date',
    ];

    public function employeeJob()
    {
        return $this->belongsTo(EmployeeJob::class);
    }
    public function payrollDetails()
    {
        return $this->hasMany(PayrollDetail::class);
    }
}
