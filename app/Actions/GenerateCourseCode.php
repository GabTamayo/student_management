<?php

namespace App\Actions;

use App\Models\Course;
use Illuminate\Support\Str;

class GenerateCourseCode
{
    public static function generateCourseCode(): string
    {
        do {
            $code = 'COURSE-' . Str::upper(Str::random(4));
        } while (Course::where('course_code', $code)->exists());

        return $code;
    }
}
