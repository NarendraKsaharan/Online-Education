<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyStudentAddressRequest;
use App\Http\Requests\StoreStudentAddressRequest;
use App\Http\Requests\UpdateStudentAddressRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\Student;
use App\Models\StudentAddress;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentAddressController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('student_address_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentAddresses = StudentAddress::with(['student', 'country', 'state', 'city'])->get();

        $students = Student::get();

        $countries = Country::get();

        $states = State::get();

        $cities = City::get();

        return view('frontend.studentAddresses.index', compact('cities', 'countries', 'states', 'studentAddresses', 'students'));
    }

    public function create()
    {
        abort_if(Gate::denies('student_address_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $students = Student::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $countries = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $states = State::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.studentAddresses.create', compact('cities', 'countries', 'states', 'students'));
    }

    public function store(StoreStudentAddressRequest $request)
    {
        $studentAddress = StudentAddress::create($request->all());

        return redirect()->route('frontend.student-addresses.index');
    }

    public function edit(StudentAddress $studentAddress)
    {
        abort_if(Gate::denies('student_address_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $students = Student::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $countries = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $states = State::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $studentAddress->load('student', 'country', 'state', 'city');

        return view('frontend.studentAddresses.edit', compact('cities', 'countries', 'states', 'studentAddress', 'students'));
    }

    public function update(UpdateStudentAddressRequest $request, StudentAddress $studentAddress)
    {
        $studentAddress->update($request->all());

        return redirect()->route('frontend.student-addresses.index');
    }

    public function show(StudentAddress $studentAddress)
    {
        abort_if(Gate::denies('student_address_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentAddress->load('student', 'country', 'state', 'city');

        return view('frontend.studentAddresses.show', compact('studentAddress'));
    }

    public function destroy(StudentAddress $studentAddress)
    {
        abort_if(Gate::denies('student_address_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentAddress->delete();

        return back();
    }

    public function massDestroy(MassDestroyStudentAddressRequest $request)
    {
        $studentAddresses = StudentAddress::find(request('ids'));

        foreach ($studentAddresses as $studentAddress) {
            $studentAddress->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
