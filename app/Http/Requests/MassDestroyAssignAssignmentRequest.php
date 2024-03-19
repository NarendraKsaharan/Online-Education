<?php

namespace App\Http\Requests;

use App\Models\AssignAssignment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAssignAssignmentRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('assign_assignment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:assign_assignments,id',
        ];
    }
}
