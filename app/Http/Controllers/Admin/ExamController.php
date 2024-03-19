<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyExamRequest;
use App\Http\Requests\StoreExamRequest;
use App\Http\Requests\UpdateExamRequest;
use App\Models\Course;
use App\Models\Exam;
use App\Models\Plan;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('exam_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Exam::with(['course', 'plans'])->select(sprintf('%s.*', (new Exam)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'exam_show';
                $editGate      = 'exam_edit';
                $deleteGate    = 'exam_delete';
                $crudRoutePart = 'exams';

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
                return $row->status ? Exam::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('plan', function ($row) {
                $labels = [];
                foreach ($row->plans as $plan) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $plan->title);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'course', 'plan']);

            return $table->make(true);
        }

        $courses = Course::get();
        $plans   = Plan::get();

        return view('admin.exams.index', compact('courses', 'plans'));
    }

    public function create()
    {
        abort_if(Gate::denies('exam_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $plans = Plan::pluck('title', 'id');

        return view('admin.exams.create', compact('courses', 'plans'));
    }

    public function store(StoreExamRequest $request)
    {
        $exam = Exam::create($request->all());
        $exam->plans()->sync($request->input('plans', []));

        return redirect()->route('admin.exams.index');
    }

    public function edit(Exam $exam)
    {
        abort_if(Gate::denies('exam_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $plans = Plan::pluck('title', 'id');

        $exam->load('course', 'plans');

        return view('admin.exams.edit', compact('courses', 'exam', 'plans'));
    }

    public function update(UpdateExamRequest $request, Exam $exam)
    {
        $exam->update($request->all());
        $exam->plans()->sync($request->input('plans', []));

        return redirect()->route('admin.exams.index');
    }

    public function show(Exam $exam)
    {
        abort_if(Gate::denies('exam_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $exam->load('course', 'plans', 'examQuestions');

        return view('admin.exams.show', compact('exam'));
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

    public function getExam(Request $request){
        $courseId = $request->input('course_id');
        $exams = Exam::where('course_id', $courseId)->get();
        $html = '<option value="">Select Exam</option>';

        foreach ($exams as $exam) {
            $html.= '<option value="'.$exam->id.'">'.$exam->title.'</option>';
        }
        return $html;
    }
}
