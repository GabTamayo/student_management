<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::apiResource('students', \App\Http\Controllers\StudentController::class);
Route::apiResource('courses', \App\Http\Controllers\CourseController::class);
Route::apiResource('enrollments', \App\Http\Controllers\EnrollmentController::class);
