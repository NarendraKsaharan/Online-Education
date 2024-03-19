<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Http\Resources\Admin\TopicResource;
use App\Models\Topic;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TopicApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('topic_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TopicResource(Topic::with(['course'])->get());
    }

    public function store(StoreTopicRequest $request)
    {
        $topic = Topic::create($request->all());

        return (new TopicResource($topic))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Topic $topic)
    {
        abort_if(Gate::denies('topic_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TopicResource($topic->load(['course']));
    }

    public function update(UpdateTopicRequest $request, Topic $topic)
    {
        $topic->update($request->all());

        return (new TopicResource($topic))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Topic $topic)
    {
        abort_if(Gate::denies('topic_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $topic->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
