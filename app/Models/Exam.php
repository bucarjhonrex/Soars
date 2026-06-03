<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $table = 'exam';

    protected $fillable = [
        'exam_date',
        'start_time',
        'end_time',
        'station',
        'total_score',
        'slots',
        'used_slots',
        'status',
    ];

  public function students()
{
    return $this->belongsToMany(Student::class, 'exam_assignments')
                ->withPivot('score')
                ->withTimestamps();
}


}
