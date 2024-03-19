<?php

namespace App\Http\Requests;

use App\Models\StudentAddress;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyStudentAddressRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('student_address_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:student_addresses,id',
        ];
    }
}
