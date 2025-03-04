<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\Grade;

class GradePolicy
{
    /**
     * Determine if the student can view their own grades.
     */
    public function view(Student $student, Grade $grade)
    {
        // Ensure the grade belongs to the student
        return $student->id === $grade->student_id;
    }
}
