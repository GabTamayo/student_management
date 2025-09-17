<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        return response()->json(
            Enrollment::with(['student', 'course'])->get()
        );
    }

    public function store(Request $request)
    {
        $enrollment = Enrollment::create($request->validate([
            'student_id'  => 'required|exists:students,id',
            'course_id'   => 'required|exists:courses,id',
            'enrolled_at' => 'required|date',
        ]));

        return response()->json($enrollment->load(['student', 'course']), 201);
    }

    public function show(Enrollment $enrollment)
    {
        return response()->json($enrollment->load(['student', 'course']));
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $enrollment->update($request->validate([
            'student_id'  => 'sometimes|required|exists:students,id',
            'course_id'   => 'sometimes|required|exists:courses,id',
            'enrolled_at' => 'sometimes|required|date',
        ]));

        return response()->json($enrollment->load(['student', 'course']));
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return response()->json(null, 204);
    }
}
