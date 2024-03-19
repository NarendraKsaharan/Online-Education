<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class AssignAssignmentController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('assign_assignment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = AssignAssignment::with(['course', 'students', 'assignments'])->select(sprintf('%s.*', (new AssignAssignment)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'assign_assignment_show';
                $editGate      = 'assign_assignment_edit';
                $deleteGate    = 'assign_assignment_delete';
                $crudRoutePart = 'assign-assignments';

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

            $table->editColumn('student', function ($row) {
                $labels = [];
                foreach ($row->students as $student) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $student->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('assignment', function ($row) {
                $labels = [];
                foreach ($row->assignments as $assignment) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $assignment->title);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'course', 'student', 'assignment']);

            return $table->make(true);
        }

        $courses     = Course::get();
        $students    = Student::get();
        $assignments = Assignment::get();

        return view('admin.assignAssignments.index', compact('courses', 'students', 'assignments'));
    }

    public function create()
    {
        abort_if(Gate::denies('assign_assignment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $students = Student::pluck('name', 'id');

        $assignments = Assignment::pluck('title', 'id');

        return view('admin.assignAssignments.create', compact('assignments', 'courses', 'students'));
    }

    public function store(StoreAssignAssignmentRequest $request)
    {
        $assignAssignment = AssignAssignment::create($request->all());
        $assignAssignment->students()->sync($request->input('students', []));
        $assignAssignment->assignments()->sync($request->input('assignments', []));

        return redirect()->route('admin.assign-assignments.index');
    }

    public function edit(AssignAssignment $assignAssignment)
    {
        abort_if(Gate::denies('assign_assignment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $students = Student::pluck('name', 'id');

        $assignments = Assignment::pluck('title', 'id');

        $assignAssignment->load('course', 'students', 'assignments');

        return view('admin.assignAssignments.edit', compact('assignAssignment', 'assignments', 'courses', 'students'));
    }

    public function update(UpdateAssignAssignmentRequest $request, AssignAssignment $assignAssignment)
    {
        $assignAssignment->update($request->all());
        $assignAssignment->students()->sync($request->input('students', []));
        $assignAssignment->assignments()->sync($request->input('assignments', []));

        return redirect()->route('admin.assign-assignments.index');
    }

    public function show(AssignAssignment $assignAssignment)
    {
        abort_if(Gate::denies('assign_assignment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assignAssignment->load('course', 'students', 'assignments');

        return view('admin.assignAssignments.show', compact('assignAssignment'));
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

    // public function assignTask()
    // {
    //     $allCourse = Course::all();
    //     $allStudent = Student::all();
    //     $allAssignment = Assignment::all();
    //     // $course = Course::where('id', 1)->first();
    //     // $assignments = $course->courseAssignments()->get();
    //     // dd($assignments);
    //     return view('admin.assignAssignments.assigntask', compact('allCourse', 'allStudent', 'allAssignment'));
    // }

    public function getAssignment(Request $request){
        $courseId = $request->input('course_id');
        // $course = Course::where('id', $courseId)->first();
        // $assignments = $course->courseAssignments()->get();
        $assignments = Assignment::where('course_id', $courseId)->get();
        $html = '<option value="">Select Assignment</option>';

        foreach ($assignments as $assignment) {
            $html.= '<option value="'.$assignment->id.'">'.$assignment->title.'</option>';
        }
        return $html;
    }
}
