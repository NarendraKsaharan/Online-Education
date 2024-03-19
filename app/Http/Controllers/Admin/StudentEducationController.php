<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyStudentEducationRequest;
use App\Http\Requests\StoreStudentEducationRequest;
use App\Http\Requests\UpdateStudentEducationRequest;
use App\Models\Student;
use App\Models\StudentEducation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class StudentEducationController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('student_education_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = StudentEducation::with(['student'])->select(sprintf('%s.*', (new StudentEducation)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'student_education_show';
                $editGate      = 'student_education_edit';
                $deleteGate    = 'student_education_delete';
                $crudRoutePart = 'student-educations';

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
            $table->addColumn('student_name', function ($row) {
                return $row->student ? $row->student->name : '';
            });

            $table->editColumn('class', function ($row) {
                return $row->class ? $row->class : '';
            });

            $table->editColumn('percentage', function ($row) {
                return $row->percentage ? $row->percentage : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'student']);

            return $table->make(true);
        }

        $students = Student::get();

        return view('admin.studentEducations.index', compact('students'));
    }

    public function create()
    {
        abort_if(Gate::denies('student_education_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $students = Student::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.studentEducations.create', compact('students'));
    }

    public function store(StoreStudentEducationRequest $request)
    {
        $studentEducation = StudentEducation::create($request->all());

        return redirect()->route('admin.student-educations.index');
    }

    public function edit(StudentEducation $studentEducation)
    {
        abort_if(Gate::denies('student_education_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $students = Student::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $studentEducation->load('student');

        return view('admin.studentEducations.edit', compact('studentEducation', 'students'));
    }

    public function update(UpdateStudentEducationRequest $request, StudentEducation $studentEducation)
    {
        $studentEducation->update($request->all());

        return redirect()->route('admin.student-educations.index');
    }

    public function show(StudentEducation $studentEducation)
    {
        abort_if(Gate::denies('student_education_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentEducation->load('student');

        return view('admin.studentEducations.show', compact('studentEducation'));
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
