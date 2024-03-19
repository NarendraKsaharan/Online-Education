<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCourseVideoRequest;
use App\Http\Requests\UpdateCourseVideoRequest;
use App\Http\Resources\Admin\CourseVideoResource;
use App\Models\CourseVideo;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CourseVideoApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('course_video_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CourseVideoResource(CourseVideo::with(['course', 'topic'])->get());
    }

    public function store(StoreCourseVideoRequest $request)
    {
        $courseVideo = CourseVideo::create($request->all());

        return (new CourseVideoResource($courseVideo))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CourseVideo $courseVideo)
    {
        abort_if(Gate::denies('course_video_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CourseVideoResource($courseVideo->load(['course', 'topic']));
    }

    public function update(UpdateCourseVideoRequest $request, CourseVideo $courseVideo)
    {
        $courseVideo->update($request->all());

        return (new CourseVideoResource($courseVideo))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CourseVideo $courseVideo)
    {
        abort_if(Gate::denies('course_video_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courseVideo->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
