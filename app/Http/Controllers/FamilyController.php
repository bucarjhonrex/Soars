<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FamilyInfo;
use App\Models\Student;

class FamilyController extends Controller
{

    public function getFam(){
          $students = Student::with('user')->get();
        return response()->json($students);
    }
    public function store(Request $request){
        foreach(['family_member','father','mother','guardian' ] as $family){
            FamilyInfo::create([
                'student_id'=>$request->student_id,
                'family_member'=>$family,
                'fname'=>$request->fname,
                'lname'=>$request->lname,
                'mname'=>$request->mname,
                'suffix'=>$request->suffix,
                'contact_no'=>$request->contact_no,
                'email'=>$request->email,
                'occupation'=>$request->occupation,
                'livstatus'=>$request->livstatus,
            ]);
        }
        return response()->json(['meesage'=>'Application submitted successfully']);
    }
}
/*
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

*/
