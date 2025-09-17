<?php

namespace App\Http\Controllers\Api;

use App\Actions\GenerateStudentNo;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Student::with('courses')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|min:2|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:students',
            'address'    => 'required|string|max:255',
        ]);

        $student = Student::create(array_merge($validated, [
            'student_no' => GenerateStudentNo::generateStudentNo(),
        ]));

        return response()->json($student, 201);
    }

    public function show(Student $student)
    {
        return response()->json($student->load('courses'));
    }

    public function update(Request $request, Student $student)
    {
        $student->update($request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'last_name'  => 'sometimes|required|string|max:255',
            'email'      => 'sometimes|required|email|unique:students,email,' . $student->id,
            'address'    => 'nullable|string|max:255',
            'student_no' => 'sometimes|required|string|unique:students,student_no,' . $student->id,
        ]));

        return response()->json($student);
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return response()->json(null, 204);
    }
}
