<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            if (!Schema::hasColumn('enrollments', 'schedule_id')) {
                $table->foreignId('schedule_id')
                      ->nullable()
                      ->constrained('schedules')
                      ->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            if (Schema::hasColumn('enrollments', 'schedule_id')) {
                $table->dropForeign(['schedule_id']);
                $table->dropColumn('schedule_id');
            }
        });
    }
};
