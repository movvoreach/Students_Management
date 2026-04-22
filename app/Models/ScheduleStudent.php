<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleStudent extends Model
{
    protected $table = 'schedule_students';

    protected $fillable = [
        'schedule_id',
        'student_id',
    ];
}
