<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FamilyInfo extends Model
{
    use HasFactory;

    // Optional if table name is not the default 'family_infos'
    protected $table = 'family_info';

    protected $fillable = [
        'student_id',
        'family_member',
        'fname',
        'lname',
        'mname',
        'suffix',
        'contact_no',
        'email',
        'occupation',
        'livstatus',
    ];

    // Relationship to Student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
