<?php

namespace App\Http\Requests;

use App\Models\StudentEducation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateStudentEducationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('student_education_edit');
    }

    public function rules()
    {
        return [
            'student_id' => [
                'required',
                'integer',
            ],
            'class' => [
                'string',
                'required',
            ],
            'university' => [
                'required',
            ],
            'passing_year' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'percentage' => [
                'string',
                'required',
            ],
        ];
    }
}
