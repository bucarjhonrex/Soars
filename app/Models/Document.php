<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'student_id',
        'document_name',
        'file_path',
        'Status',
    ];
      public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }
}
