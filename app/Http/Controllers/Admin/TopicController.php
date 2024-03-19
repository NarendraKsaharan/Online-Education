<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTopicRequest;
use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Models\Course;
use App\Models\Topic;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TopicController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('topic_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Topic::with(['course'])->select(sprintf('%s.*', (new Topic)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'topic_show';
                $editGate      = 'topic_edit';
                $deleteGate    = 'topic_delete';
                $crudRoutePart = 'topics';

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

            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? Topic::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'course']);

            return $table->make(true);
        }

        $courses = Course::get();

        return view('admin.topics.index', compact('courses'));
    }

    public function create()
    {
        abort_if(Gate::denies('topic_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.topics.create', compact('courses'));
    }

    public function store(StoreTopicRequest $request)
    {
        $topic = Topic::create($request->all());

        return redirect()->route('admin.topics.index');
    }

    public function edit(Topic $topic)
    {
        abort_if(Gate::denies('topic_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $topic->load('course');

        return view('admin.topics.edit', compact('courses', 'topic'));
    }

    public function update(UpdateTopicRequest $request, Topic $topic)
    {
        $topic->update($request->all());

        return redirect()->route('admin.topics.index');
    }

    public function show(Topic $topic)
    {
        abort_if(Gate::denies('topic_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $topic->load('course', 'topicCourseVideos');

        return view('admin.topics.show', compact('topic'));
    }

    public function destroy(Topic $topic)
    {
        abort_if(Gate::denies('topic_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $topic->delete();

        return back();
    }

    public function massDestroy(MassDestroyTopicRequest $request)
    {
        $topics = Topic::find(request('ids'));

        foreach ($topics as $topic) {
            $topic->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
