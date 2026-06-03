<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
           'student_id',
        'type',
        'region',
        'province',
        'city',
        'barangay',
        'zip',
        'household_income',
    ];
    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }
}
