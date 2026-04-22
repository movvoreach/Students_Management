<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();

            $table->string('teacher_code')->unique();
            $table->string('name');
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();

            $table->string('phone')->nullable();
            $table->string('email')->unique();

            $table->string('password');

            $table->string('subject')->nullable();
            $table->string('image')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
