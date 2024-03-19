<?php

namespace App\Http\Requests;

use App\Models\Question;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreQuestionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('question_create');
    }

    public function rules()
    {
        return [
            'course_id' => [
                'required',
                'integer',
            ],
            'exam_id' => [
                'required',
                'integer',
            ],
            'status' => [
                'required',
            ],
            'type' => [
                'required',
            ],
            'question' => [
                'required',
            ],
            'image' => [
                'array',
            ],
            'answer' => [
                'required',
            ],
            'answer_image' => [
                'array',
            ],
        ];
    }
}
