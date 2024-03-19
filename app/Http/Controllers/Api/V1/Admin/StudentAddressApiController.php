<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentAddressRequest;
use App\Http\Requests\UpdateStudentAddressRequest;
use App\Http\Resources\Admin\StudentAddressResource;
use App\Models\StudentAddress;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentAddressApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('student_address_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StudentAddressResource(StudentAddress::with(['student', 'country', 'state', 'city'])->get());
    }

    public function store(StoreStudentAddressRequest $request)
    {
        $studentAddress = StudentAddress::create($request->all());

        return (new StudentAddressResource($studentAddress))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(StudentAddress $studentAddress)
    {
        abort_if(Gate::denies('student_address_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StudentAddressResource($studentAddress->load(['student', 'country', 'state', 'city']));
    }

    public function update(UpdateStudentAddressRequest $request, StudentAddress $studentAddress)
    {
        $studentAddress->update($request->all());

        return (new StudentAddressResource($studentAddress))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(StudentAddress $studentAddress)
    {
        abort_if(Gate::denies('student_address_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentAddress->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
