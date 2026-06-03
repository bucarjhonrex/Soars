<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index(){
    $totalStudents = Student::count();
    $pendingAdmissions = Student::where('student_status', 'Pending')->count();
    $completedAdmissions = Student::where('student_status','Completed')->count();

    return response()->json([
        'totalStudents'=>$totalStudents,
        'pendingAdmissions'=>$pendingAdmissions,
        'completedAdmissions'=>$completedAdmissions,
    ]);
    }
    public function recentStudents(){
        $recentStudents = Student::with('user')
            ->orderBy('created_at', 'desc')->take(5)->get();

            return response()->json($recentStudents);
    }

   public function recentApplications()
{
    $recentApplications = Student::with(['user', 'applicationInfo.firstCourse'])
        ->whereHas('applicationInfo')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    return response()->json($recentApplications);
}

}
