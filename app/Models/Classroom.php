<?php
namespace App\Models;

use App\Models\Schedule;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    //
    protected $table = 'classes';

    protected $fillable = [
        'class_name',
        'table',
        'status',
    ];
    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments', 'class_id', 'student_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'class_id');
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'class_id');
    }

}
