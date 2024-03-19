<?php

namespace App\Http\Requests;

use App\Models\Page;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePageRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('page_create');
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
            'show_in_menu' => [
                'required',
            ],
            'show_in_footer' => [
                'required',
            ],
            'status' => [
                'required',
            ],
            'description' => [
                'required',
            ],
            'page_image' => [
                'array',
            ],
            'slug' => [
                'string',
                'required',
                'unique:pages',
            ],
            'meta_tag' => [
                'string',
                'required',
            ],
            'meta_title' => [
                'string',
                'required',
            ],
            'meta_description' => [
                'required',
            ],
        ];
    }
}
