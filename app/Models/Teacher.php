<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'teacher_code',
        'name',
        'gender',
        'dob',
        'phone',
        'email',
        'password',
        'subject',
        'image',
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}
}
