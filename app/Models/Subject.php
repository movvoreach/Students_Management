<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    // If your table is 'subjects', Eloquent finds it automatically from 'Subject'
    protected $fillable = [
        'subject_name'
    ];

    /**
     * Relationship with Schedules
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Relationship with Students (Many-to-Many)
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }
    public function department() {
    return $this->belongsTo(Department::class);
    }
}
