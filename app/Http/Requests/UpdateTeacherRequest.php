<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRequest extends FormRequest
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
        return [
            'teacher_code' => 'required|string|max:50',
            'name'         => 'required|string|max:255',
            'gender'       => 'required|string',
            'dob'          => 'required|date',
            'phone'        => 'required|string|max:20',
            'email'        => 'required|email',
            'subject'      => 'required|string|max:100',
            'password'     => 'nullable|string|min:6',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
