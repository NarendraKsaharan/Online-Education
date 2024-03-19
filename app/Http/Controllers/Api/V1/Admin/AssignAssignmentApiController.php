<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssignAssignmentRequest;
use App\Http\Requests\UpdateAssignAssignmentRequest;
use App\Http\Resources\Admin\AssignAssignmentResource;
use App\Models\AssignAssignment;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AssignAssignmentApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('assign_assignment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AssignAssignmentResource(AssignAssignment::with(['course', 'students', 'assignments'])->get());
    }

    public function store(StoreAssignAssignmentRequest $request)
    {
        $assignAssignment = AssignAssignment::create($request->all());
        $assignAssignment->students()->sync($request->input('students', []));
        $assignAssignment->assignments()->sync($request->input('assignments', []));

        return (new AssignAssignmentResource($assignAssignment))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AssignAssignment $assignAssignment)
    {
        abort_if(Gate::denies('assign_assignment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AssignAssignmentResource($assignAssignment->load(['course', 'students', 'assignments']));
    }

    public function update(UpdateAssignAssignmentRequest $request, AssignAssignment $assignAssignment)
    {
        $assignAssignment->update($request->all());
        $assignAssignment->students()->sync($request->input('students', []));
        $assignAssignment->assignments()->sync($request->input('assignments', []));

        return (new AssignAssignmentResource($assignAssignment))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AssignAssignment $assignAssignment)
    {
        abort_if(Gate::denies('assign_assignment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assignAssignment->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
