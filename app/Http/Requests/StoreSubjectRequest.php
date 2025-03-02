<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubjectRequest extends FormRequest
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
            'subjectCode' => 'required|string|max:225',
            'sectionCode' => 'required|string|max:225|unique:subjects,sectionCode',
            'description' => 'required|string|max:225|unique:subjects,description',
            'units' => 'required|integer',
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'sectionCode' => strtoupper(trim($this->sectionCode)),
        ]);
    }
}
