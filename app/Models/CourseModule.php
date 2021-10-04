<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseModule extends Model
{
    protected $fillable = [
        'name'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
