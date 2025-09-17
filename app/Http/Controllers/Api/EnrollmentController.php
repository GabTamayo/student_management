<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        return response()->json(
            Enrollment::with(['student', 'course'])
                ->orderBy('enrolled_at', 'desc')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id'  => 'required|exists:students,id',
            'course_id'   => 'required|exists:courses,id',
        ]);

        $data['enrolled_at'] = now();

        $enrollment = Enrollment::create($data);

        return response()->json($enrollment->load(['student', 'course']), 201);
    }

    public function show(Enrollment $enrollment)
    {
        return response()->json($enrollment->load(['student', 'course']));
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return response()->json(null, 204);
    }
}
