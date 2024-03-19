<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExamRequest;
use App\Http\Requests\UpdateExamRequest;
use App\Http\Resources\Admin\ExamResource;
use App\Models\Exam;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExamApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('exam_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExamResource(Exam::with(['course', 'plans'])->get());
    }

    public function store(StoreExamRequest $request)
    {
        $exam = Exam::create($request->all());
        $exam->plans()->sync($request->input('plans', []));

        return (new ExamResource($exam))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Exam $exam)
    {
        abort_if(Gate::denies('exam_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExamResource($exam->load(['course', 'plans']));
    }

    public function update(UpdateExamRequest $request, Exam $exam)
    {
        $exam->update($request->all());
        $exam->plans()->sync($request->input('plans', []));

        return (new ExamResource($exam))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Exam $exam)
    {
        abort_if(Gate::denies('exam_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $exam->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
