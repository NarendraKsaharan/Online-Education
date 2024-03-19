<?php

namespace App\Http\Requests;

use App\Models\Block;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBlockRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('block_edit');
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
                'unique:blocks,slug,' . request()->route('block')->id,
            ],
            'block_image' => [
                'array',
            ],
        ];
    }
}
