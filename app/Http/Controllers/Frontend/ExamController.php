<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyExamRequest;
use App\Http\Requests\StoreExamRequest;
use App\Http\Requests\UpdateExamRequest;
use App\Models\Course;
use App\Models\Student;
use App\Models\Exam;
use App\Models\Plan;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('exam_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $student = Student::where('user_id', Auth::user()->id)->first();

        $courses = $student->courses;

        $exams = Exam::with(['course', 'plans'])
                 ->whereHas('course', function ($query) use ($student) {
                     $query->whereIn('id', $student->courses->pluck('id'));
                 })
                 ->get();
        $plans = Plan::whereIn('course_id', $courses->pluck('id'))->get();        

        // $exams = Exam::with(['course', 'plans'])->get();
        // $courses = Course::get();
        // $plans = Plan::get();

        return view('frontend.exams.index', compact('courses', 'exams', 'plans'));
    }

    public function create()
    {
        abort_if(Gate::denies('exam_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $plans = Plan::pluck('title', 'id');

        return view('frontend.exams.create', compact('courses', 'plans'));
    }

    public function store(StoreExamRequest $request)
    {
        $exam = Exam::create($request->all());
        $exam->plans()->sync($request->input('plans', []));

        return redirect()->route('frontend.exams.index');
    }

    public function edit(Exam $exam)
    {
        abort_if(Gate::denies('exam_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $plans = Plan::pluck('title', 'id');

        $exam->load('course', 'plans');

        return view('frontend.exams.edit', compact('courses', 'exam', 'plans'));
    }

    public function update(UpdateExamRequest $request, Exam $exam)
    {
        $exam->update($request->all());
        $exam->plans()->sync($request->input('plans', []));

        return redirect()->route('frontend.exams.index');
    }

    public function show(Exam $exam)
    {
        abort_if(Gate::denies('exam_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $exam->load('course', 'plans');

        return view('frontend.exams.show', compact('exam'));
    }

    public function destroy(Exam $exam)
    {
        abort_if(Gate::denies('exam_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $exam->delete();

        return back();
    }

    public function massDestroy(MassDestroyExamRequest $request)
    {
        $exams = Exam::find(request('ids'));

        foreach ($exams as $exam) {
            $exam->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function takeExam(Request $request)
    {
        // dd($request->all());
        $isPrivate = $request->input('private', 0);
        $examId = $request->input('exam_id');

        $exam = Exam::find($examId);

        $exam->load('examQuestions.questionOptions');
        // dd($exam);

        return view('frontend.exams.takeexam', compact('isPrivate', 'exam'));
    }
}
