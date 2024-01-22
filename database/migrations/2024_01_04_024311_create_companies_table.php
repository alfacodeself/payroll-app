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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('phone')->unique();
            $table->text('address')->nullable();
            $table->enum('status', [
                Status::ACTIVE->value,
                Status::INACTIVE->value,
                Status::DEACTIVATED->value,
                Status::EXPIRED->value,
            ]);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
