<?php

namespace App\Http\Requests;

use App\Models\Exam;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateExamRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('exam_edit');
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
            'status' => [
                'required',
            ],
            'plans.*' => [
                'integer',
            ],
            'plans' => [
                'required',
                'array',
            ],
        ];
    }
}
