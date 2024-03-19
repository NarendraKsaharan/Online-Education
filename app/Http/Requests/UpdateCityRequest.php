<?php

namespace App\Http\Requests;

use App\Models\City;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCityRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('city_edit');
    }

    public function rules()
    {
        return [
            'country_id' => [
                'required',
                'integer',
            ],
            'state_id' => [
                'required',
                'integer',
            ],
            'name' => [
                'string',
                'required',
            ],
            'status' => [
                'required',
            ],
        ];
    }
}
