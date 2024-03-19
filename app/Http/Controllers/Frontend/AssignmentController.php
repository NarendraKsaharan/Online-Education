<?php

namespace App\Http\Controllers\Frontend;

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

class AssignmentController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('assignment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assignments = Assignment::with(['course', 'students', 'media'])->get();

        $courses = Course::get();

        $students = Student::get();

        return view('frontend.assignments.index', compact('assignments', 'courses', 'students'));
    }

    public function create()
    {
        abort_if(Gate::denies('assignment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $students = Student::pluck('name', 'id');

        return view('frontend.assignments.create', compact('courses', 'students'));
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

        return redirect()->route('frontend.assignments.index');
    }

    public function edit(Assignment $assignment)
    {
        abort_if(Gate::denies('assignment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $students = Student::pluck('name', 'id');

        $assignment->load('course', 'students');

        return view('frontend.assignments.edit', compact('assignment', 'courses', 'students'));
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

        return redirect()->route('frontend.assignments.index');
    }

    public function show(Assignment $assignment)
    {
        abort_if(Gate::denies('assignment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assignment->load('course', 'students', 'assignmentAssignAssignments');

        return view('frontend.assignments.show', compact('assignment'));
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
