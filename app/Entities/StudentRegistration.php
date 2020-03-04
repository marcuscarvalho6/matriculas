<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class StudentRegistration extends Model
{
    protected $table = 'student_registrations';

    protected $fillable = ['student_id', 'course_id'];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_registrations', 'student_id', 'course_id', 'student_id');
    }
}
