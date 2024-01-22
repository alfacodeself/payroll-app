<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Status;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendance_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_id')->constrained('attendances')->cascadeOnDelete();
            $table->foreignId('employee_job_id')->constrained('employee_jobs')->cascadeOnDelete();
            $table->time('attendance_time');
            $table->integer('job_qty');
            $table->string('proof')->nullable();
            $table->enum('payment_status', [
                Status::PAID->value,
                Status::UNPAID->value,
            ]);
            $table->dateTime('paid_at')->nullable()->default(NULL);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_employees');
    }
};
