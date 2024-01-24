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
    public function attendanceEmployees()
    {
        return $this->hasMany(AttendanceEmployee::class);
    }
}
