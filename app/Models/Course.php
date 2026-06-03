<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course',
        'slots',
        'used_slots',
    ];
    public function student(){
        return $this->hasOne(Student::class);
    }

}
