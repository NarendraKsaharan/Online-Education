<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCourseVideoRequest;
use App\Http\Requests\StoreCourseVideoRequest;
use App\Http\Requests\UpdateCourseVideoRequest;
use App\Models\Course;
use App\Models\CourseVideo;
use App\Models\Topic;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CourseVideoController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('course_video_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CourseVideo::with(['course', 'topic'])->select(sprintf('%s.*', (new CourseVideo)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'course_video_show';
                $editGate      = 'course_video_edit';
                $deleteGate    = 'course_video_delete';
                $crudRoutePart = 'course-videos';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('course_title', function ($row) {
                return $row->course ? $row->course->title : '';
            });

            $table->addColumn('topic_title', function ($row) {
                return $row->topic ? $row->topic->title : '';
            });

            $table->editColumn('video_title', function ($row) {
                return $row->video_title ? $row->video_title : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'course', 'topic']);

            return $table->make(true);
        }

        $courses = Course::get();
        $topics  = Topic::get();

        return view('admin.courseVideos.index', compact('courses', 'topics'));
    }

    public function create()
    {
        abort_if(Gate::denies('course_video_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $topics = Topic::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.courseVideos.create', compact('courses', 'topics'));
    }

    public function store(StoreCourseVideoRequest $request)
    {
        $courseVideo = CourseVideo::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $courseVideo->id]);
        }

        return redirect()->route('admin.course-videos.index');
    }

    public function edit(CourseVideo $courseVideo)
    {
        abort_if(Gate::denies('course_video_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $topics = Topic::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $courseVideo->load('course', 'topic');

        return view('admin.courseVideos.edit', compact('courseVideo', 'courses', 'topics'));
    }

    public function update(UpdateCourseVideoRequest $request, CourseVideo $courseVideo)
    {
        $courseVideo->update($request->all());

        return redirect()->route('admin.course-videos.index');
    }

    public function show(CourseVideo $courseVideo)
    {
        abort_if(Gate::denies('course_video_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courseVideo->load('course', 'topic');

        return view('admin.courseVideos.show', compact('courseVideo'));
    }

    public function destroy(CourseVideo $courseVideo)
    {
        abort_if(Gate::denies('course_video_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courseVideo->delete();

        return back();
    }

    public function massDestroy(MassDestroyCourseVideoRequest $request)
    {
        $courseVideos = CourseVideo::find(request('ids'));

        foreach ($courseVideos as $courseVideo) {
            $courseVideo->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('course_video_create') && Gate::denies('course_video_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CourseVideo();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
