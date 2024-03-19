<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\Admin\StudentResource;
use App\Models\Student;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('student_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StudentResource(Student::with(['user', 'courses'])->get());
    }

    public function store(StoreStudentRequest $request)
    {
        $student = Student::create($request->all());
        $student->courses()->sync($request->input('courses', []));
        if ($request->input('profile_image', false)) {
            $student->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile_image'))))->toMediaCollection('profile_image');
        }

        return (new StudentResource($student))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Student $student)
    {
        abort_if(Gate::denies('student_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StudentResource($student->load(['user', 'courses']));
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->all());
        $student->courses()->sync($request->input('courses', []));
        if ($request->input('profile_image', false)) {
            if (! $student->profile_image || $request->input('profile_image') !== $student->profile_image->file_name) {
                if ($student->profile_image) {
                    $student->profile_image->delete();
                }
                $student->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile_image'))))->toMediaCollection('profile_image');
            }
        } elseif ($student->profile_image) {
            $student->profile_image->delete();
        }

        return (new StudentResource($student))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Student $student)
    {
        abort_if(Gate::denies('student_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $student->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
