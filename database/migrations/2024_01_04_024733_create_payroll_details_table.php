<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\PayrollType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payroll_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_id')->constrained('payrolls')->cascadeOnDelete();
            $table->foreignId('attendance_employee_id')->nullable()->constrained('attendance_employees')->cascadeOnDelete();
            $table->integer('base_price');
            $table->integer('qty');
            $table->integer('total');
            $table->string('note');
            $table->enum('payroll_type', [
                PayrollType::ADDITIONAL->value,
                PayrollType::DEDUCTION->value,
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_details');
    }
};
