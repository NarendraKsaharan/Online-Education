<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyStudentEducationRequest;
use App\Http\Requests\StoreStudentEducationRequest;
use App\Http\Requests\UpdateStudentEducationRequest;
use App\Models\Student;
use App\Models\StudentEducation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentEducationController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('student_education_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentEducations = StudentEducation::with(['student'])->get();

        $students = Student::get();

        return view('frontend.studentEducations.index', compact('studentEducations', 'students'));
    }

    public function create()
    {
        abort_if(Gate::denies('student_education_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $students = Student::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.studentEducations.create', compact('students'));
    }

    public function store(StoreStudentEducationRequest $request)
    {
        $studentEducation = StudentEducation::create($request->all());

        return redirect()->route('frontend.student-educations.index');
    }

    public function edit(StudentEducation $studentEducation)
    {
        abort_if(Gate::denies('student_education_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $students = Student::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $studentEducation->load('student');

        return view('frontend.studentEducations.edit', compact('studentEducation', 'students'));
    }

    public function update(UpdateStudentEducationRequest $request, StudentEducation $studentEducation)
    {
        $studentEducation->update($request->all());

        return redirect()->route('frontend.student-educations.index');
    }

    public function show(StudentEducation $studentEducation)
    {
        abort_if(Gate::denies('student_education_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentEducation->load('student');

        return view('frontend.studentEducations.show', compact('studentEducation'));
    }

    public function destroy(StudentEducation $studentEducation)
    {
        abort_if(Gate::denies('student_education_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentEducation->delete();

        return back();
    }

    public function massDestroy(MassDestroyStudentEducationRequest $request)
    {
        $studentEducations = StudentEducation::find(request('ids'));

        foreach ($studentEducations as $studentEducation) {
            $studentEducation->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
