<?php

namespace App\Http\Requests;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
            'name'=> 'required',
            'address'=> 'required'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'name' => strip_tags($this -> name),
            'address' => strip_tags($this -> address)
        ]);
    }
}
