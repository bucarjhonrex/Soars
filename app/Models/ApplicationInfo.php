<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationInfo extends Model
{
    use HasFactory;

    protected $table = 'application_info';

    protected $fillable = [
        'student_id',
        'first_course_applied_id',
        'second_course_applied_id',
        'third_course_applied_id',
        'lrn',
        'education_level',
        'classification',
        'student_type',
        'remarks',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function firstCourse()
{
    return $this->belongsTo(Course::class);
}
}
