<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleRequest extends FormRequest
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
            //
            'department_id' => 'required',
            'subject_id' =>'required',
            'teacher_id' => 'required',
            'class_id'   => 'required',
            'day'        => 'required',
            'start_time' => 'required',
            'end_time'   => 'required',
        ];
    }
}
