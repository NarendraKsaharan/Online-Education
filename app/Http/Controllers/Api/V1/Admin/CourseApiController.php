<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\Admin\CourseResource;
use App\Models\Course;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CourseApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('course_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CourseResource(Course::all());
    }

    public function store(StoreCourseRequest $request)
    {
        $course = Course::create($request->all());

        foreach ($request->input('image', []) as $file) {
            $course->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        foreach ($request->input('pdf', []) as $file) {
            $course->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('pdf');
        }

        return (new CourseResource($course))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Course $course)
    {
        abort_if(Gate::denies('course_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CourseResource($course);
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->all());

        if (count($course->image) > 0) {
            foreach ($course->image as $media) {
                if (! in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $course->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $course->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        if (count($course->pdf) > 0) {
            foreach ($course->pdf as $media) {
                if (! in_array($media->file_name, $request->input('pdf', []))) {
                    $media->delete();
                }
            }
        }
        $media = $course->pdf->pluck('file_name')->toArray();
        foreach ($request->input('pdf', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $course->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('pdf');
            }
        }

        return (new CourseResource($course))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Course $course)
    {
        abort_if(Gate::denies('course_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $course->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
