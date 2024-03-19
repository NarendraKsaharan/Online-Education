<?php

namespace App\Http\Requests;

use App\Models\Assignment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAssignmentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('assignment_edit');
    }

    public function rules()
    {
        return [
            'course_id' => [
                'required',
                'integer',
            ],
            'title' => [
                'string',
                'required',
            ],
            'description' => [
                'required',
            ],
            'image' => [
                'array',
            ],
            'pdf' => [
                'array',
            ],
            'points' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            // 'students.*' => [
            //     'integer',
            // ],
            // 'students' => [
            //     'required',
            //     'array',
            // ],
        ];
    }
}
