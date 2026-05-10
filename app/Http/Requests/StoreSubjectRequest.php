<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
<<<<<<< HEAD
     return [
        'subject_name' => 'required|string|max:255|unique:subjects,subject_name',

        'department_id' => 'required|integer|exists:departments,id',
=======
        return [
            //
            'subject_name' => 'required|string|max:255|unique:subjects,subject_name',
            'department_id' => 'required|exists:departments,id',
>>>>>>> 76e73daff4800ff2b39ac38c1463607781ccef23
        ];
    }
}
