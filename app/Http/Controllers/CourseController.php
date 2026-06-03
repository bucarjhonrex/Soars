<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use App\Models\Student;

class CourseController extends Controller
{
 public function index() {
        return response()->json(Course::all());
    }

    // Add a new course
    public function store(Request $request) {
        $request->validate([
            'course' => 'required|string|max:255',
            'slots' => 'required|integer|min:0',
        ]);

        $course = Course::create([
            'course' => $request->course,
            'slots' => $request->slots,
        ]);

        return response()->json($course);
    }

    // Update a course
    public function update(Request $request, $id) {
        $course = Course::findOrFail($id);

        $request->validate([
            'course' => 'required|string|max:255',
            'slots' => 'required|integer|min:0',
        ]);

        $course->update([
            'course' => $request->course,
            'slots' => $request->slots,
        ]);

        return response()->json($course);
    }

    // Delete a course
    public function destroy($id) {
        $course = Course::findOrFail($id);
        $course->delete();

        return response()->json(['message' => 'Course deleted']);
    }


public function eligibleStudents()
{
    // Fetch students who have exam scores, with user info and applications
    $students = Student::with(['user', 'application', ])
        ->whereHas('exams', function ($query) {
            $query->whereNotNull('score');
        })
        ->get()
        ->map(function ($student) {
            return [
                'id' => $student->id,
                'fname' => $student->user->fname ?? '',
                'lname' => $student->user->lname ?? '',
                'course_id' => $student->course_id,
                'first_course_applied_id' => $student->application->first_course_applied_id ?? null,
                'second_course_applied_id' => $student->application->second_course_applied_id ?? null,
                'third_course_applied_id' => $student->application->third_course_applied_id ?? null,
            ];
        });

    return response()->json($students);
}


// In CourseController.php
public function coursesForStudent($studentId)
{
    $application = DB::table('applications')->where('student_id', $studentId)->first();

    if (!$application) return response()->json([]);

    $courseIds = array_filter([
        $application->first_course_applied_id,
        $application->second_course_applied_id,
        $application->third_course_applied_id
    ]);

    $courses = DB::table('courses')->whereIn('id', $courseIds)->get();

    return response()->json($courses);
}

// Already in CourseController, just make sure it's clean
public function assignCourse(Request $request)
{
    $request->validate([
        'student_id' => 'required|integer',
        'course_id' => 'required|integer',
    ]);

    DB::table('students')
        ->where('id', $request->student_id)
        ->update(['course_id' => $request->course_id]);

    return response()->json(['message' => 'Course assigned successfully!']);
}


}
