<?php

namespace App\Http\Requests;

use App\Models\Student;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreStudentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('student_create');
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
            ],
            'courses.*' => [
                'integer',
            ],
            'courses' => [
                'array',
            ],
            'name' => [
                'string',
                'max:150',
                'required',
            ],
            'phone' => [
                'string',
                'max:100',
                'nullable',
            ],
            'gender' => [
                'required',
            ],
            'join_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'leave_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
