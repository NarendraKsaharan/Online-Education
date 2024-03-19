<?php

namespace App\Http\Requests;

use App\Models\FeeRecord;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFeeRecordRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('fee_record_create');
    }

    public function rules()
    {
        return [
            'courses.*' => [
                'integer',
            ],
            'courses' => [
                'array',
            ],
            'students.*' => [
                'integer',
            ],
            'students' => [
                'required',
                'array',
            ],
            'fee' => [
                'required',
            ],
            'join_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
