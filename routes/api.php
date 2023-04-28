<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Courses\CourseController;
use App\Http\Controllers\Students\StudentsController;
use App\Http\Controllers\Students\StudentsCourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('top/courses/count', [StudentsCourseController::class, 'countTopCourses']);

    Route::resource('students.courses', StudentsCourseController::class)->only(['index', 'store']);

    Route::apiResources([
        'courses' => CourseController::class,
        'students' => StudentsController::class
    ]);
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

