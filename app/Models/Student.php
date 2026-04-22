<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Classroom;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_code',
        'user_id',
        'name',
        'gender',
        'dob',
        'class',
        'phone',
        'email',
        'image',
    ];
    public function classes()
    {
        return $this->belongsToMany(Classroom::class, 'enrollments');
    }

public function schedules()
{
    return $this->belongsToMany(
        Schedule::class,
        'schedule_students',
        'student_id',
        'schedule_id'
    );
}
}
