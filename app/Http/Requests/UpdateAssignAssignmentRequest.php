<?php

namespace App\Http\Requests;

use App\Models\AssignAssignment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAssignAssignmentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('assign_assignment_edit');
    }

    public function rules()
    {
        return [
            'course_id' => [
                'required',
                'integer',
            ],
            'students.*' => [
                'integer',
            ],
            'students' => [
                'required',
                'array',
            ],
            'assignments.*' => [
                'integer',
            ],
            'assignments' => [
                'required',
                'array',
            ],
        ];
    }
}
