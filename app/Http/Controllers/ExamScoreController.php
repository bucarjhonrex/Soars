<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\ExamAssignment;

class ExamScoreController extends Controller
{
    public function getScore()
    {
        $user = Auth::user();

        // Get student row
        $student = Student::where('user_id', $user->id)->first();

        if (!$student) {
            return response()->json([
                'score' => null,
                'status' => 'No Record'
            ]);
        }

        // Get exam assignment (score)
        $assignment = ExamAssignment::where('student_id', $student->id)->first();

        if (!$assignment || $assignment->score === null) {
            return response()->json([
                'score' => null,
                'status' => 'Awaiting Results'
            ]);
        }

        return response()->json([
            'score' => $assignment->score,
            'status' => 'Completed'
        ]);
    }
}
