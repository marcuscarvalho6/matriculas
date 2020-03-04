<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title', 'description'];

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
}
