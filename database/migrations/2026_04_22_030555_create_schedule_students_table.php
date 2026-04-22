<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule_students', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('schedule_id');
            $table->unsignedBigInteger('student_id');

            $table->timestamps();

            // Foreign keys
            $table->foreign('schedule_id')
                ->references('id')
                ->on('schedules')
                ->onDelete('cascade');

            $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->onDelete('cascade');

            // Prevent duplicate enrollment
            $table->unique(['schedule_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_students');
    }
};
