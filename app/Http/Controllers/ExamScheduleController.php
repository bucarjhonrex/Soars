<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Exam;
use App\Models\Student;

class ExamScheduleController extends Controller
{
    public function getStudentExam()
    {
        $user = Auth::user();

        // Get student row by user_id
        $student = Student::where('user_id', $user->id)->first();

        if (!$student || !$student->exam_id) {
            return response()->json([
                'exam' => null
            ]);
        }

        // Get assigned exam schedule
        $exam = Exam::find($student->exam_id);

        return response()->json([
            'exam' => $exam
        ]);
    }
}
