<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EducationInfo;
use App\Models\Student;

class EducationController extends Controller
{
        public function getIded(){
        $students = Student::with('user')->get();
        return response()->json($students);
    }
    public function store(Request $request){
        foreach(['elementary', 'junoir', 'senior', 'college'] as $level){
            EducationInfo::create([
                'student_id'=>$request->student_id,
                'level'=>$level,
                'school_name'=>$request->school_name,
                'address'=>$request->address,
                'year_graduated'=>$request->year_graduated,
                'honors'=>$request->honors,
            ]);
        }
          return response()->json(['meesage'=>'Application submitted successfully']);
    }

}

