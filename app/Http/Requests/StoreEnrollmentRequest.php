<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Enrollment;

class StoreEnrollmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            // Custom validation to prevent duplicate enrollment
            'student_id' => [
                'required',
                'exists:students,id',
                function ($attribute, $value, $fail) {
                    $subjectId = $this->input('subject_id');
                    $existingEnrollment = Enrollment::where('student_id', $value)
                                                    ->where('subject_id', $subjectId)
                                                    ->exists();

                    if ($existingEnrollment) {
                        $fail('The student is already enrolled in this subject.');
                    }
                },
            ],
        ];
    }
}
