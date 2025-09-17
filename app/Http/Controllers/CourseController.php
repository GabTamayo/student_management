<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        return response()->json(Course::with('students')->get());
    }

    public function store(Request $request)
    {
        $course = Course::create($request->validate([
            'course_name' => 'required|string|max:255',
            'course_code' => 'required|string|max:50|unique:courses',
            'description' => 'required|string',
        ]));

        return response()->json($course, 201);
    }

    public function show(Course $course)
    {
        return response()->json($course->load('students'));
    }

    public function update(Request $request, Course $course)
    {
        $course->update($request->validate([
            'course_name' => 'sometimes|required|string|max:255',
            'course_code' => 'sometimes|required|string|max:50|unique:courses,course_code,' . $course->id,
            'description' => 'sometimes|required|string',
        ]));

        return response()->json($course);
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json(null, 204);
    }
}
