<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendance_history', function (Blueprint $table) {
            $table->id();
            $table->string('attendance_id');
            $table->string('employee_id');
            $table->timestamp('date_attendance');
            $table->tinyInteger('attendance_type');
            $table->text('description');
            $table->foreign('attendance_id')->references('attendance_id')->on('attendances')->onDelete('cascade');
            $table->foreign('employee_id')->references('employee_id')->on('employees')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_history');
    }
};
