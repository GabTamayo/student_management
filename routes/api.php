<?php

use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\EnrollmentController;
use App\Http\Controllers\Api\StudentController;
use Illuminate\Support\Facades\Route;

Route::apiResource('students', StudentController::class);
Route::apiResource('courses', CourseController::class);
Route::apiResource('enrollments', EnrollmentController::class);
