<?php

namespace App\Http\Requests;

use App\Models\StudentAddress;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreStudentAddressRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('student_address_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'country_id' => [
                'required',
                'integer',
            ],
            'state_id' => [
                'required',
                'integer',
            ],
            'city_id' => [
                'required',
                'integer',
            ],
            'pincode' => [
                'string',
                'nullable',
            ],
        ];
    }
}