<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCourseRequest;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Models\Topic;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('course_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Course::query()->select(sprintf('%s.*', (new Course)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'course_show';
                $editGate      = 'course_edit';
                $deleteGate    = 'course_delete';
                $crudRoutePart = 'courses';

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
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? Course::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('fee', function ($row) {
                return $row->fee ? $row->fee : '';
            });
            $table->editColumn('fee_type', function ($row) {
                return $row->fee_type ? Course::FEE_TYPE_SELECT[$row->fee_type] : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.courses.index');
    }

    public function create()
    {
        abort_if(Gate::denies('course_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.courses.create');
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

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $course->id]);
        }

        $topicTitle = $request->input('topic_title', []);
        $topicStatus = $request->input('topic_status', []);

        foreach ($topicTitle as $key => $topic_title) {
            $topic_status = $topicStatus[$key]??0;
            // $topic_status = isset($topicStatus[$key]) ? $topicStatus[$key] : 1;

            if ($topic_title) {
                Topic::create([
                    'course_id' => $course->id,
                    'title'     => $topic_title,
                    'status'    => $topic_status
                ]);
            }
        }

        return redirect()->route('admin.courses.index');
    }

    public function edit(Course $course)
    {
        abort_if(Gate::denies('course_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $topics = Topic::where('course_id', $course->id)->get();

        return view('admin.courses.edit', compact('course', 'topics'));
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

        $topicId = $request->input('topic_id', []);
        $topicTitle = $request->input('topic_title', []);
        // dd($topicTitle);
        $topicStatus = $request->input('topic_status', []);

        Topic::whereNotIn('id', $topicId)->where('course_id', $course->id)->delete();

        foreach ($topicTitle as $key => $topic_title) {
            $topic_id = $topicId[$key]??0;
            $topic_status = $topicStatus[$key];

            if ($topic_id) {
                Topic::where('id', $topic_id)->update([
                    'title'  => $topic_title,
                    'status' => $topic_status
                ]);
            } else {
                Topic::create([
                    'course_id' => $course->id,
                    'title'     => $topic_title,
                    'status'    => $topic_status
                ]);
            }
        }

        return redirect()->route('admin.courses.index');
    }

    public function show(Course $course)
    {
        abort_if(Gate::denies('course_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $course->load('courseCourseVideos', 'courseAssignments', 'courseAssignAssignments', 'coursePlans', 'courseTopics', 'courseExams', 'courseQuestions', 'courseFees');

        return view('admin.courses.show', compact('course'));
    }

    public function destroy(Course $course)
    {
        abort_if(Gate::denies('course_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $course->delete();
        $topic = Topic::where('course_id', $course->id)->get();
        $topic->delete();

        return back();
    }

    public function massDestroy(MassDestroyCourseRequest $request)
    {
        $courses = Course::find(request('ids'));

        foreach ($courses as $course) {
            $course->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('course_create') && Gate::denies('course_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Course();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
