<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplicationInfo;
use App\Models\Address;
use App\Models\Course;
use App\Models\Student;

class ApplicationInfoController extends Controller
{
    public function getCourses(){
        return response()->json(Course::all());
    }
    public function getStudents(){
        $students = Student::with('user')->get();
        return response()->json($students);
    }
    public function store(Request $request){
        $application = ApplicationInfo::create([
            'student_id'=>$request->student_id,
            'first_course_applied'=>$request->first_course,
            'second_course_applied'=>$request->second_course,
            'third_course_applied'=>$request->third_course,
            'lrn'=>$request->lrn,
            'education_level'=>$request->education_level,
            'classification'=>$request->classification,
            'student_type'=>$request->student_type,
            'remarks'=>$request->remarks ?? null,
        ]);
        foreach(['permanent','current'] as $type){
            Address::create([
                'student_id'=>$request->student_id,
                'type'=>$type,
                'region'=>$request["{$type}_region"],
                'province'=>$request["{$type}_province"],
                'city'=>$request["{$type}_city"],
                'barangay'=>$request["{$type}_barangay"],
                'zip'=>$request["{$type}_zip"],
                'house_income'=>$request["{$type}_house_income"],
            ]);
        }
        return response()->json(['meesage'=>'Application submitted successfully']);
    }
}
