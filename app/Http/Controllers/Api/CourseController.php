<?php

namespace App\Http\Controllers\Api;

use App\Actions\GenerateCourseCode;
use App\Http\Controllers\Controller;
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
        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $validated['course_code'] = GenerateCourseCode::generateCourseCode();

        $course = Course::create($validated);

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
