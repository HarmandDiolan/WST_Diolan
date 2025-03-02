<?php

namespace App\Http\Requests;
use App\Models\Grade;
use Illuminate\Foundation\Http\FormRequest;

class StoreGradeRequest extends FormRequest
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
        'studentId' => 'required|exists:students,id',
        'subjectCode' => 'required|exists:subjects,subjectCode',
        'sectionCode' => 'required|exists:subjects,sectionCode',
        'grade' => 'required|numeric|in:1.00,1.25,1.50,1.75,2.00,2.25,2.50,2.75,3.00,3.25,3.50,3.75,4.00,4.25,4.50,4.75,5.00',
        // Custom validation to check if grade already exists
        'studentId' => [
            'required',
            'exists:students,id',
            function ($attribute, $value, $fail) {
                $subjectCode = $this->input('subjectCode');
                $existingGrade = Grade::where('student_id', $value)
                                      ->where('subject_code', $subjectCode)
                                      ->exists();
                if ($existingGrade) {
                    $fail('A grade has already been added for this student in this subject.');
                }
            },
        ],
    ];
}

}
