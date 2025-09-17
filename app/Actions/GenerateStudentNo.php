<?php

namespace App\Actions;

use App\Models\Student;

class GenerateStudentNo
{
    public static function generateStudentNo(): string
    {
        $year = now()->format('y');

        $lastStudent = Student::where('student_no', 'like', $year . '-%')
            ->orderBy('student_no', 'desc')
            ->first();

        if ($lastStudent) {
            $parts = explode('-', $lastStudent->student_no);
            $middle = (int) $parts[1] + 1;
        } else {
            $middle = 1;
        }

        $middleFormatted = str_pad($middle, 5, '0', STR_PAD_LEFT);
        $lastFormatted = str_pad('1', 3, '0', STR_PAD_LEFT);

        return "{$year}-{$middleFormatted}-{$lastFormatted}";
    }
}
