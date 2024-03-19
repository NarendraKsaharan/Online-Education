<?php

namespace App\Http\Requests;

use App\Models\Option;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOptionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('option_edit');
    }

    public function rules()
    {
        return [
            'question_id' => [
                'required',
                'integer',
            ],
            'option_sequence' => [
                'required',
            ],
            'option_value' => [
                'string',
                'required',
            ],
            'option_image' => [
                'array',
            ],
        ];
    }
}
