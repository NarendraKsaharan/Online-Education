<?php

namespace App\Http\Requests;

use App\Models\Course;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCourseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('course_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'status' => [
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
            'fee_type' => [
                'required',
            ],
        ];
    }
}
