<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAssignmentRequest;
use App\Http\Requests\StoreAssignmentRequest;
use App\Http\Requests\UpdateAssignmentRequest;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Student;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AssignmentController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('assignment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Assignment::with(['course', 'students'])->select(sprintf('%s.*', (new Assignment)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'assignment_show';
                $editGate      = 'assignment_edit';
                $deleteGate    = 'assignment_delete';
                $crudRoutePart = 'assignments';

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
            $table->editColumn('points', function ($row) {
                return $row->points ? $row->points : '';
            });
            $table->editColumn('student', function ($row) {
                $labels = [];
                foreach ($row->students as $student) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $student->name);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'course', 'student']);

            return $table->make(true);
        }

        $courses  = Course::get();
        $students = Student::get();

        return view('admin.assignments.index', compact('courses', 'students'));
    }

    public function create()
    {
        abort_if(Gate::denies('assignment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $students = Student::pluck('name', 'id');

        return view('admin.assignments.create', compact('courses', 'students'));
    }

    public function store(StoreAssignmentRequest $request)
    {
        $assignment = Assignment::create($request->all());
        $assignment->students()->sync($request->input('students', []));
        foreach ($request->input('image', []) as $file) {
            $assignment->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        foreach ($request->input('pdf', []) as $file) {
            $assignment->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('pdf');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $assignment->id]);
        }

        return redirect()->route('admin.assignments.index');
    }

    public function edit(Assignment $assignment)
    {
        abort_if(Gate::denies('assignment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $students = Student::pluck('name', 'id');

        $assignment->load('course', 'students');

        return view('admin.assignments.edit', compact('assignment', 'courses', 'students'));
    }

    public function update(UpdateAssignmentRequest $request, Assignment $assignment)
    {
        $assignment->update($request->all());
        $assignment->students()->sync($request->input('students', []));
        if (count($assignment->image) > 0) {
            foreach ($assignment->image as $media) {
                if (! in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $assignment->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $assignment->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        if (count($assignment->pdf) > 0) {
            foreach ($assignment->pdf as $media) {
                if (! in_array($media->file_name, $request->input('pdf', []))) {
                    $media->delete();
                }
            }
        }
        $media = $assignment->pdf->pluck('file_name')->toArray();
        foreach ($request->input('pdf', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $assignment->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('pdf');
            }
        }

        return redirect()->route('admin.assignments.index');
    }

    public function show(Assignment $assignment)
    {
        abort_if(Gate::denies('assignment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assignment->load('course', 'students', 'assignmentAssignAssignments');

        return view('admin.assignments.show', compact('assignment'));
    }

    public function destroy(Assignment $assignment)
    {
        abort_if(Gate::denies('assignment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assignment->delete();

        return back();
    }

    public function massDestroy(MassDestroyAssignmentRequest $request)
    {
        $assignments = Assignment::find(request('ids'));

        foreach ($assignments as $assignment) {
            $assignment->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('assignment_create') && Gate::denies('assignment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Assignment();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
