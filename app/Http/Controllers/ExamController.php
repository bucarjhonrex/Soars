<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Student;
use App\Models\ExamAssignment;
use App\Models\ApplicationInfo;
use Illuminate\Support\Facades\Auth;
class ExamController extends Controller
{
    public function index(){

            $items = Exam::all();
        return response()->json($items);
    }
    public function store(Request $request){

        $request->validate([
            'exam_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'station' => 'required',
        ]);

        Exam::create([
            'exam_date' => $request->exam_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'station' => $request->station,
            'total_score' => $request->total_score,
            'status' => 'Scheduled',
            'slots' => $request->slots,
            'used_slots' => $request->used_slots,
        ]);

        return back()->with('success', 'Exam created!');
    }
    public function show(){
             $students = Student::with('user')->get();

    return $students->map(function ($student) {
        return [
            'id' => $student->id,
            'fname' => $student->user->fname,
            'lname' => $student->user->lname,
            'mname' => $student->user->mname,
            'email' => $student->user->email,
        ];
    });
    }
      public function delete($id){
         $exam = Exam::findOrFail($id);
        $exam->delete();

        return response()->json(['message' => 'Exam deleted']);
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'exam_date' => 'sometimes|nullable|date',
        'start_time' => 'sometimes|nullable',
        'end_time' => 'sometimes|nullable',
        'station' => 'sometimes|nullable',
        'status' => 'sometimes|nullable',
        'slots' => 'sometimes|nullable|integer',
        'used_slots' => 'sometimes|nullable|integer'
    ]);

    $exam = Exam::findOrFail($id);
   $exam->update([
    'exam_date' => $request->exam_date,
    'start_time' => $request->start_time,
    'end_time' => $request->end_time,
    'station' => $request->station,
    'status' => $request->status,
    'slots' => $request->slots,
    'used_slots' => $request->used_slots,
]);


    return response()->json(['message' => 'Exam updated']);
}

public function assignStudent(Request $request)
{
    $request->validate([
        'student_id' => 'required|integer',
        'exam_id' => 'required|integer',
        'score' => 'sometimes|nullable|integer',
    ]);

    $existing = ExamAssignment::where('student_id', $request->student_id)->first();

    // ✅ Student already assigned → do NOT change exam_id
    if ($existing) {
        $existing->update([
            'score' => $request->score
        ]);

        return response()->json([
            'message' => 'Score updated successfully!'
        ]);
    }

    // Student not assigned yet → continue normal process
    $exam = Exam::findOrFail($request->exam_id);

    // Check slots
    if ($exam->used_slots >= $exam->slots) {
        return response()->json([
            'message' => 'Exam is already full!'
        ], 400);
    }

    ExamAssignment::create([
        'student_id' => $request->student_id,
        'exam_id' => $request->exam_id,
        'score' => $request->score ?? null,
    ]);

    $exam->increment('used_slots');

    return response()->json([
        'message' => 'Student assigned to exam!'
    ]);
}

public function getStudentExam($id)
{
    $assignment = ExamAssignment::where('student_id', $id)->first();

    return response()->json([
        'exam_id' => $assignment ? $assignment->exam_id : null
    ]);
}

public function progress()
{
    $user = Auth::user();
    $student=Student::where('user_id',$user->id)->first();

    if (!$student) {
        return response()->json([
            'fully_registered' => true,
            'exam_scheduled' => false,
            'results_released' => false,
            'application_submitted' => false,
            'status' => 'pending'
        ]);
    }

    $assignment = ExamAssignment::where('student_id', $student->id)->first();

    $examScheduled = $assignment ? true : false;
    $resultsReleased = $assignment && $assignment->score !== null;
    $applicationSubmitted = in_array($student->student_status, ['Accepted', 'Completed']);
    $status = $applicationSubmitted ? 'complete' : 'pending';

    return response()->json([
        'fully_registered' => true,
        'exam_scheduled' => $examScheduled,
        'results_released' => $resultsReleased,
        'application_submitted' => $applicationSubmitted,
        'status' => $status,
    ]);
}




}
