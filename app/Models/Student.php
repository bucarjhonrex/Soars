<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'exam_id',
        'phone_number',
        'place_birth',
        'religion',
        'blood_type',
        'gender',
        'civil_status',
        'student_status',
    ];
    public function user(){
         return $this->belongsTo(User::class);
    }
    public function course(){
        return $this->belongsTo(Course::class);
    }
   public function education_info(){
    return $this->hasMany(EducationInfo::class, 'student_id');
}
public function family_info(){
    return $this->hasMany(FamilyInfo::class, 'student_id');
}
public function documents(){
    return $this->hasMany(Document::class,'student_id');
}
public function exams()
{
    return $this->belongsToMany(Exam::class, 'exam_assignments')
                ->withPivot('score')
                ->withTimestamps();
}
public function examAssignment()
{
    return $this->hasOne(ExamAssignment::class);
}



}
