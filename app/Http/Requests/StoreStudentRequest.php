<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'age' => 'required|integer|min:1',
            'password' => 'sometimes|string|min:8', // Add default password handling later
            'role' => 'sometimes|string|in:student', // Ensure role is always 'student'
        ];
    }
    
    protected function prepareForValidation()
    {
        $this->merge([
            'name' => strip_tags($this->name),  // Strip any HTML tags from name
            'address' => strip_tags($this->address),  // Strip any HTML tags from address
            'role' => 'student',  // Ensure the role is always 'student'
            // Handle password: If no password is provided, we will set it to 'password123'
            'password' => $this->password ? bcrypt($this->password) : bcrypt('password123'),
        ]);
    }
}
