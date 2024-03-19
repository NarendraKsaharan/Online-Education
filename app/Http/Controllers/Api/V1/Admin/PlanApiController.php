<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Http\Resources\Admin\PlanResource;
use App\Models\Plan;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PlanApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('plan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PlanResource(Plan::with(['course'])->get());
    }

    public function store(StorePlanRequest $request)
    {
        $plan = Plan::create($request->all());

        return (new PlanResource($plan))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Plan $plan)
    {
        abort_if(Gate::denies('plan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PlanResource($plan->load(['course']));
    }

    public function update(UpdatePlanRequest $request, Plan $plan)
    {
        $plan->update($request->all());

        return (new PlanResource($plan))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Plan $plan)
    {
        abort_if(Gate::denies('plan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plan->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
