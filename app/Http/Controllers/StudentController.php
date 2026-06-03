<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\ApplicationInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Course;
use App\Models\Address;
use Illuminate\Validation\ValidationException;


class StudentController extends Controller
{
  public function index() {

    $students = Student::with('user', 'course')->get();

    return $students->map(function ($student) {
        return [
            'id' => $student->id,
            'fname' => $student->user->fname,
            'lname' => $student->user->lname,
            'mname' => $student->user->mname,
            'email' => $student->user->email,
            'phone_number'=>  $student->phone_number,
            'course' => $student->course ? $student->course->course : 'No Course',
            'course_id' => $student->course_id,
            'status' => $student->student_status,
        ];
    });
}
 public function getCourses(){
        return response()->json(Course::all());
    }


 public function store(Request $request)
{
  try {
    $request->validate([
        'fname' => 'required|string|max:255',
        'lname' => 'required|string|max:255',
        'mname' => 'nullable|string|max:255',
        'email' => 'required|string|lowercase|email|max:255|unique:users,email',
        'password' => ['required', Rules\Password::defaults()],
        'phone_number' => 'required|string|max:20',

        'first_course_applied_id' => 'required|integer|exists:courses,id',
        'second_course_applied_id' => 'required|integer|exists:courses,id',
        'third_course_applied_id' => 'required|integer|exists:courses,id',
            'classification' => 'required|in:New,Old,Transferee,Returnee,Shiftee',
    'student_type' => 'required|in:Local,Online,Other',
    ]);
} catch (ValidationException $e) {
    return response()->json([
        'errors' => $e->errors()
    ], 422);
}

    // Make the user
    $user = User::create([
        'fname' => $request->fname,
        'lname' => $request->lname,
        'mname' => $request->mname,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'user',
    ]);

    // Student info
    $student = Student::create([
        'user_id' => $user->id,
        'phone_number' => $request->phone_number,
    ]);

    // Application info
    ApplicationInfo::create([
        'student_id' => $student->id,
        'first_course_applied_id' => $request->first_course_applied_id,
        'second_course_applied_id' => $request->second_course_applied_id,
        'third_course_applied_id' => $request->third_course_applied_id,
            'classification' => $request->classification,
    'student_type' => $request->student_type,
    ]);

    return response()->json([
        'message' => 'Student added successfully',
        'student_id' => $student->id
    ]);
}





         /*  foreach(['permanent','current'] as $type){
            Address::create([
                'student_id'=>$request->student_id,
                'type'=>$type,
                'region'=>$request["{$type}_region"],
                'province'=>$request["{$type}_province"],
                'city'=>$request["{$type}_city"],
                'barangay'=>$request["{$type}_barangay"],
                'zip'=>$request["{$type}_zip"],
                'house_income'=>$request["{$type}_house_income"],
            ]); */

   public function update(Request $request, $id)
{
    $student = Student::findOrFail($id);
    $user = $student->user;

    // validate properly
    $validated = $request->validate([
        'fname' => 'nullable|string',
        'lname' => 'nullable|string',
        'mname' => 'nullable|string',
        'email' => 'nullable|email',
        'phone_number' => 'nullable|string',
        'course_id' => 'nullable|integer|exists:courses,id',
    ]);

    // update user part
   $user->update([
    'fname' => $validated['fname'] ?? $user->fname,
    'lname' => $validated['lname'] ?? $user->lname,
    'mname' => $validated['mname'] ?? $user->mname,
    'email' => $validated['email'] ?? $user->email,
]);


    // update student part (including course_id)
$student->update([
    'phone_number' => $validated['phone_number'] ?? $student->phone_number,
    'course_id' => $validated['course_id'] ?? $student->course_id,
]);


    return response()->json(['message' => 'Student updated successfully']);
}

    public function delete($id){
         $student = Student::findOrFail($id);
        $student->user()->delete(); // deletes user too
        $student->delete();

        return response()->json(['message' => 'Student deleted']);
    }
}
