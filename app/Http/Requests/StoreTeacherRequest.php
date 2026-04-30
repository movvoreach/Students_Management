<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

{
    return [
        // Teacher basic info
        'teacher_code' => 'required|string|unique:teachers,teacher_code',
        'name'         => 'required|string|max:255',
        'gender'       => 'nullable|in:Male,Female',
        'dob'          => 'nullable|date',
        'phone'        => 'nullable|string|max:20',
        'email'        => 'required|email|unique:users,email|unique:teachers,email',
        'password'     => 'required|string|min:6',
        'department'      => 'required|string|max:255',
        'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ];
}
    }
}
