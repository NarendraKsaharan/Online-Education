<?php

namespace App\Http\Requests;

use App\Models\Topic;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTopicRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('topic_edit');
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
        ];
    }
}
