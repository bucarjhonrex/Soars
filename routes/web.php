<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ApplicationInfoController;
use Inertia\Inertia;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ExamScheduleController;
use App\Http\Controllers\ExamScoreController;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/adminDashboard', function () {
    return Inertia::render('adminDashboard');
})->middleware(['auth', 'verified'])->name('adminDashboard');

Route::get('/AdminHome', function () {
    return Inertia::render('AdminHome');
})->middleware(['auth', 'verified'])->name('adminHome');

Route::get('/Home', function () {
    return Inertia::render('Home');
})->middleware(['auth', 'verified'])->name('Home');

Route::get('/Studentmanage', function () {
    return Inertia::render('Studentmanage');
})->middleware(['auth', 'verified'])->name('Studentmanage');

Route::get('/Calendar', function () {
    return Inertia::render('Calendar');
})->middleware(['auth', 'verified'])->name('Calendar');

Route::get('/CourseManage', function(){
    return Inertia::render('CourseManage');
})->middleware(['auth','verified'])->name('CourseManage');

Route::get('/Application', function () {
    return Inertia::render('Application');
})->middleware(['auth', 'verified'])->name('Application');

Route::get('/Progress', function () {
    return Inertia::render('Progress');
})->middleware(['auth', 'verified'])->name('Progress');


Route::middleware('auth')->group(function(){
    Route::get('/dashboard/index',[DashboardController::class, 'index']);
    Route::get('/dashboard/recent-students', [DashboardController::class, 'recentStudents']);
    Route::get('/dashboard/recent-applications', [DashboardController::class, 'recentApplications']); // ADD THIS LINE
});

Route::get('/exami', [ExamController::class, 'show']);
Route::get('/exams', [ExamController::class, 'index']);
Route::post('/exams', [ExamController::class, 'store']);
Route::put('/exams/{id}', [ExamController::class, 'update']);
Route::delete('/exams/{id}', [ExamController::class, 'destroy']);


Route::get('/studend', [StudentController::class, 'index']);
Route::put('/students/{id}', [StudentController::class, 'update']);
Route::delete('/students/{id}', [StudentController::class, 'delete']);
Route::post('/studend',[StudentController::class,'store']);

Route::get('/exams', [ExamController::class, 'index']);
Route::delete('/exams/{id}', [ExamController::class, 'delete']);
Route::put('/exams/{id}', [ExamController::class, 'update']);
Route::post('/assign-exam', [ExamController::class, 'assignStudent']);
Route::get('/student-exam/{id}', [ExamController::class, 'getStudentExam']);


Route::get('/courses', [CourseController::class, 'index']);        // get all courses
Route::post('/courses', [CourseController::class, 'store']);       // add new course
Route::put('/courses/{id}', [CourseController::class, 'update']);  // edit course
Route::delete('/courses/{id}', [CourseController::class, 'destroy']);




Route::get('/exam-progress', [ExamController::class, 'progress'])->middleware('auth');
Route::get('/student/exam-schedule', [ExamScheduleController::class, 'getStudentExam']);
Route::get('/student/exam-score', [ExamScoreController::class, 'getScore']);


Route::get('/students-eligible-for-course', [CourseController::class, 'eligibleStudents'])->middleware('auth');
Route::get('/student/{id}/applied-courses', [CourseController::class, 'coursesForStudent'])->middleware('auth');
Route::post('/assign-course', [CourseController::class, 'assignCourse'])->middleware('auth');



Route::get('/getIded', [EducationController::class, 'getIded'])->name('getIded');
Route::get('/edducation',[EducationController::class, 'store'])->name('submit.education');

Route::get('/getFam', [FamilyController::class, 'getFam'])->name('getFam');
Route::get('/family',[FamilyController::class, 'store'])->name('submit.family');

Route::get('/courses', [ApplicationInfoController::class, 'getCourses'])->name('courses');
Route::get('/students', [ApplicationInfoController::class, 'getStudents'])->name('students');
Route::post('/submit-application', [ApplicationInfoController::class, 'store'])->name('submit.application');

Route::middleware('auth')->group(function(){
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/post/fetch', [PostController::class, 'fetch'])->name('posts.fetch');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




require __DIR__.'/auth.php';
