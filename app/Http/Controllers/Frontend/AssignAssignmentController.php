<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAssignAssignmentRequest;
use App\Http\Requests\StoreAssignAssignmentRequest;
use App\Http\Requests\UpdateAssignAssignmentRequest;
use App\Models\AssignAssignment;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Student;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AssignAssignmentController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('assign_assignment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $student = Student::where('user_id', Auth::user()->id)->first();

        $assignAssignments = $student->courses->flatMap(function ($course) {
            return $course->courseAssignAssignments;
        });

        $courses = $student->courses;
        $assignments = $student->studentAssignments;

        // dd($assignAssignments);
        // $assignAssignments = AssignAssignment::with(['course', 'students', 'assignments'])->get();

        // $courses = Course::get();

        // $students = Student::get();

        // $assignments = Assignment::get();

        return view('frontend.assignAssignments.index', compact('assignAssignments', 'assignments', 'courses', 'student'));
    }

    public function create()
    {
        abort_if(Gate::denies('assign_assignment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $students = Student::pluck('name', 'id');

        $assignments = Assignment::pluck('title', 'id');

        return view('frontend.assignAssignments.create', compact('assignments', 'courses', 'students'));
    }

    public function store(StoreAssignAssignmentRequest $request)
    {
        $assignAssignment = AssignAssignment::create($request->all());
        $assignAssignment->students()->sync($request->input('students', []));
        $assignAssignment->assignments()->sync($request->input('assignments', []));

        return redirect()->route('frontend.assign-assignments.index');
    }

    public function edit(AssignAssignment $assignAssignment)
    {
        abort_if(Gate::denies('assign_assignment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $students = Student::pluck('name', 'id');

        $assignments = Assignment::pluck('title', 'id');

        $assignAssignment->load('course', 'students', 'assignments');

        return view('frontend.assignAssignments.edit', compact('assignAssignment', 'assignments', 'courses', 'students'));
    }

    public function update(UpdateAssignAssignmentRequest $request, AssignAssignment $assignAssignment)
    {
        $assignAssignment->update($request->all());
        $assignAssignment->students()->sync($request->input('students', []));
        $assignAssignment->assignments()->sync($request->input('assignments', []));

        return redirect()->route('frontend.assign-assignments.index');
    }

    public function show(AssignAssignment $assignAssignment)
    {
        abort_if(Gate::denies('assign_assignment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assignAssignment->load('course', 'students', 'assignments');

        return view('frontend.assignAssignments.show', compact('assignAssignment'));
    }

    public function destroy(AssignAssignment $assignAssignment)
    {
        abort_if(Gate::denies('assign_assignment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assignAssignment->delete();

        return back();
    }

    public function massDestroy(MassDestroyAssignAssignmentRequest $request)
    {
        $assignAssignments = AssignAssignment::find(request('ids'));

        foreach ($assignAssignments as $assignAssignment) {
            $assignAssignment->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
