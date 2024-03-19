<?php

namespace App\Http\Requests;

use App\Models\Fee;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateFeeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('fee_edit');
    }

    public function rules()
    {
        return [
            'course_id' => [
                'required',
                'integer',
            ],
            'student_id' => [
                'required',
                'integer',
            ],
            'amount' => [
                'required',
            ],
            'remark' => [
                'required',
            ],
            'payment_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
        ];
    }
}
