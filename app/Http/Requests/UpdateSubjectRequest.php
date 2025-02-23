<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubjectRequest extends FormRequest
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
        $subjectId = $this->route('subject')->id ?? null;

        return [
            'subjectCode' => 'required',
            'sectionCode' => 'required|unique:subjects,sectionCode,' . $subjectId,
            'description' => 'required',
            'units' => 'required',
        ];
    }
    
    protected function prepareForValidation()
    {
        $this->merge([
            'subjectCode' => strip_tags($this->subjectCode),
            'sectionCode' => strip_tags($this->sectionCode),
            'description' => strip_tags($this->description),
            'units' => strip_tags($this->units),
        ]);
    }
}
