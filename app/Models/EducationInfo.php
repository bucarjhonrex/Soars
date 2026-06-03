<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationInfo extends Model
{
    use HasFactory;

    protected $table = 'education_info';

    protected $fillable = [
        'student_id',
        'level',
        'school_name',
        'address',
        'year_graduated',
        'honors',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
