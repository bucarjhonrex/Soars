<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'exam_id',
        'score',
    ];

    // Relation to Exam
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    // Relation to Student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
