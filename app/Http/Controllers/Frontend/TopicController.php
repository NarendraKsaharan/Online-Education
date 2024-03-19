<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTopicRequest;
use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Models\Course;
use App\Models\Topic;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TopicController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('topic_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $topics = Topic::with(['course'])->get();

        $courses = Course::get();

        return view('frontend.topics.index', compact('courses', 'topics'));
    }

    public function create()
    {
        abort_if(Gate::denies('topic_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.topics.create', compact('courses'));
    }

    public function store(StoreTopicRequest $request)
    {
        $topic = Topic::create($request->all());

        return redirect()->route('frontend.topics.index');
    }

    public function edit(Topic $topic)
    {
        abort_if(Gate::denies('topic_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $topic->load('course');

        return view('frontend.topics.edit', compact('courses', 'topic'));
    }

    public function update(UpdateTopicRequest $request, Topic $topic)
    {
        $topic->update($request->all());

        return redirect()->route('frontend.topics.index');
    }

    public function show(Topic $topic)
    {
        abort_if(Gate::denies('topic_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $topic->load('course', 'topicCourseVideos');

        return view('frontend.topics.show', compact('topic'));
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
