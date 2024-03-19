<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyStudentRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('student_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $students = Student::with(['user', 'courses', 'media'])->get();

        $users = User::get();

        $courses = Course::get();

        return view('frontend.students.index', compact('courses', 'students', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('student_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $courses = Course::pluck('title', 'id');

        return view('frontend.students.create', compact('courses', 'users'));
    }

    public function store(StoreStudentRequest $request)
    {
        $student = Student::create($request->all());
        $student->courses()->sync($request->input('courses', []));
        if ($request->input('profile_image', false)) {
            $student->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile_image'))))->toMediaCollection('profile_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $student->id]);
        }

        return redirect()->route('frontend.students.index');
    }

    public function edit(Student $student)
    {
        abort_if(Gate::denies('student_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $courses = Course::pluck('title', 'id');

        $student->load('user', 'courses');

        return view('frontend.students.edit', compact('courses', 'student', 'users'));
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->all());
        $student->courses()->sync($request->input('courses', []));
        if ($request->input('profile_image', false)) {
            if (! $student->profile_image || $request->input('profile_image') !== $student->profile_image->file_name) {
                if ($student->profile_image) {
                    $student->profile_image->delete();
                }
                $student->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile_image'))))->toMediaCollection('profile_image');
            }
        } elseif ($student->profile_image) {
            $student->profile_image->delete();
        }

        return redirect()->route('frontend.students.index');
    }

    public function show(Student $student)
    {
        abort_if(Gate::denies('student_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $student->load('user', 'courses', 'studentStudentAddresses', 'studentFees', 'studentStudentEducations', 'studentAssignments', 'studentAssignAssignments', 'studentFeeRecords');

        return view('frontend.students.show', compact('student'));
    }

    public function destroy(Student $student)
    {
        abort_if(Gate::denies('student_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $student->delete();

        return back();
    }

    public function massDestroy(MassDestroyStudentRequest $request)
    {
        $students = Student::find(request('ids'));

        foreach ($students as $student) {
            $student->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('student_create') && Gate::denies('student_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Student();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
