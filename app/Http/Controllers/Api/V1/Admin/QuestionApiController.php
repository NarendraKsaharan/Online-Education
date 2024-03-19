<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Http\Resources\Admin\QuestionResource;
use App\Models\Question;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuestionApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('question_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new QuestionResource(Question::with(['course', 'exam'])->get());
    }

    public function store(StoreQuestionRequest $request)
    {
        $question = Question::create($request->all());

        foreach ($request->input('image', []) as $file) {
            $question->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        foreach ($request->input('answer_image', []) as $file) {
            $question->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('answer_image');
        }

        return (new QuestionResource($question))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Question $question)
    {
        abort_if(Gate::denies('question_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new QuestionResource($question->load(['course', 'exam']));
    }

    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $question->update($request->all());

        if (count($question->image) > 0) {
            foreach ($question->image as $media) {
                if (! in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $question->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $question->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        if (count($question->answer_image) > 0) {
            foreach ($question->answer_image as $media) {
                if (! in_array($media->file_name, $request->input('answer_image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $question->answer_image->pluck('file_name')->toArray();
        foreach ($request->input('answer_image', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $question->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('answer_image');
            }
        }

        return (new QuestionResource($question))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Question $question)
    {
        abort_if(Gate::denies('question_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $question->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
