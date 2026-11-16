<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['department_id', 'student_no', 'first_name', 'last_name', 'email'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function profile()
    {
        return $this->hasOne(StudentProfile::class); // one-to-one
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'enrollments')
            ->withPivot('school_year')
            ->withTimestamps(); // many-to-many
    }
}