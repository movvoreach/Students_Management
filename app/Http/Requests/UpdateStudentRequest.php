<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Student;
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array

    {
        $student = $this->route('student');
        return [
            //
            'student_code' => 'required|unique:students,student_code,' . $student->id,
            'name'         => 'required',
            'email'        => 'required|email|unique:students,email,' . $student->id,
            'class'        => 'required',
            'name'       => 'required',
            'gender'     => 'required',
            'dob'        => 'required|date',
            'phone'      => 'required',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
