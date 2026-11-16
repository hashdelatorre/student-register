<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['code', 'name', 'units'];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments')
            ->withPivot('school_year')
            ->withTimestamps();
    }
}