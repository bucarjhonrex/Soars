<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class StudentSchedule extends Model
{
    protected $fillable = [
        'student_id',
        'schedule_type',
        'schedule_type',
        'scheduled_time_start',
        "scheduled_time_end",
        'description',
        'status',
    ];
      public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }
}
