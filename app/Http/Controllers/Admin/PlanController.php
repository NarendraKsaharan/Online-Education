<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPlanRequest;
use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Models\Course;
use App\Models\Plan;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('plan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Plan::with(['course'])->select(sprintf('%s.*', (new Plan)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'plan_show';
                $editGate      = 'plan_edit';
                $deleteGate    = 'plan_delete';
                $crudRoutePart = 'plans';

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
                return $row->status ? Plan::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('price', function ($row) {
                return $row->price ? $row->price : '';
            });
            $table->editColumn('special_price', function ($row) {
                return $row->special_price ? $row->special_price : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'course']);

            return $table->make(true);
        }

        $courses = Course::get();

        return view('admin.plans.index', compact('courses'));
    }

    public function create()
    {
        abort_if(Gate::denies('plan_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.plans.create', compact('courses'));
    }

    public function store(StorePlanRequest $request)
    {
        $plan = Plan::create($request->all());

        return redirect()->route('admin.plans.index');
    }

    public function edit(Plan $plan)
    {
        abort_if(Gate::denies('plan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $plan->load('course');

        return view('admin.plans.edit', compact('courses', 'plan'));
    }

    public function update(UpdatePlanRequest $request, Plan $plan)
    {
        $plan->update($request->all());

        return redirect()->route('admin.plans.index');
    }

    public function show(Plan $plan)
    {
        abort_if(Gate::denies('plan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plan->load('course', 'planExams');

        return view('admin.plans.show', compact('plan'));
    }

    public function destroy(Plan $plan)
    {
        abort_if(Gate::denies('plan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plan->delete();

        return back();
    }

    public function massDestroy(MassDestroyPlanRequest $request)
    {
        $plans = Plan::find(request('ids'));

        foreach ($plans as $plan) {
            $plan->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
