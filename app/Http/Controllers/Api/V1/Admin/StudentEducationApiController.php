<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentEducationRequest;
use App\Http\Requests\UpdateStudentEducationRequest;
use App\Http\Resources\Admin\StudentEducationResource;
use App\Models\StudentEducation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentEducationApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('student_education_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StudentEducationResource(StudentEducation::with(['student'])->get());
    }

    public function store(StoreStudentEducationRequest $request)
    {
        $studentEducation = StudentEducation::create($request->all());

        return (new StudentEducationResource($studentEducation))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(StudentEducation $studentEducation)
    {
        abort_if(Gate::denies('student_education_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StudentEducationResource($studentEducation->load(['student']));
    }

    public function update(UpdateStudentEducationRequest $request, StudentEducation $studentEducation)
    {
        $studentEducation->update($request->all());

        return (new StudentEducationResource($studentEducation))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(StudentEducation $studentEducation)
    {
        abort_if(Gate::denies('student_education_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentEducation->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
