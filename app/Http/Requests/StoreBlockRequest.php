<?php

namespace App\Http\Requests;

use App\Models\Block;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBlockRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('block_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'heading' => [
                'string',
                'required',
            ],
            'status' => [
                'required',
            ],
            'description' => [
                'required',
            ],
            'slug' => [
                'string',
                'required',
                'unique:blocks',
            ],
            'block_image' => [
                'array',
            ],
        ];
    }
}
