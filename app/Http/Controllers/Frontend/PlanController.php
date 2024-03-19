<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPlanRequest;
use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Models\Course;
use App\Models\Student;
use App\Models\Plan;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('plan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $student = Student::where('user_id', Auth::user()->id)->first();
        $plans = collect();
        
        if ($student) {
            foreach ($student->courses as $course) {
                $plans = $plans->merge($course->coursePlans);
            }
        }
        // $plans = Plan::with(['course'])->get();
        $courses = Course::get();

        return view('frontend.plans.index', compact('courses', 'plans'));
    }

    public function create()
    {
        abort_if(Gate::denies('plan_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.plans.create', compact('courses'));
    }

    public function store(StorePlanRequest $request)
    {
        $plan = Plan::create($request->all());

        return redirect()->route('frontend.plans.index');
    }

    public function edit(Plan $plan)
    {
        abort_if(Gate::denies('plan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $plan->load('course');

        return view('frontend.plans.edit', compact('courses', 'plan'));
    }

    public function update(UpdatePlanRequest $request, Plan $plan)
    {
        $plan->update($request->all());

        return redirect()->route('frontend.plans.index');
    }

    public function show(Plan $plan)
    {
        abort_if(Gate::denies('plan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plan->load('course');

        return view('frontend.plans.show', compact('plan'));
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
