<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFeeRequest;
use App\Http\Requests\StoreFeeRequest;
use App\Http\Requests\UpdateFeeRequest;
use App\Models\Course;
use App\Models\Fee;
use App\Models\Student;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class FeeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('fee_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fees = Fee::with(['course', 'student'])->get();

        $courses = Course::get();

        $students = Student::get();

        return view('frontend.fees.index', compact('courses', 'fees', 'students'));
    }

    public function create()
    {
        abort_if(Gate::denies('fee_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $students = Student::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.fees.create', compact('courses', 'students'));
    }

    public function store(StoreFeeRequest $request)
    {
        $fee = Fee::create($request->all());

        return redirect()->route('frontend.fees.index');
    }

    public function edit(Fee $fee)
    {
        abort_if(Gate::denies('fee_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $students = Student::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $fee->load('course', 'student');

        return view('frontend.fees.edit', compact('courses', 'fee', 'students'));
    }

    public function update(UpdateFeeRequest $request, Fee $fee)
    {
        $fee->update($request->all());

        return redirect()->route('frontend.fees.index');
    }

    public function show(Fee $fee)
    {
        abort_if(Gate::denies('fee_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fee->load('course', 'student');

        return view('frontend.fees.show', compact('fee'));
    }

    public function destroy(Fee $fee)
    {
        abort_if(Gate::denies('fee_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fee->delete();

        return back();
    }

    public function massDestroy(MassDestroyFeeRequest $request)
    {
        $fees = Fee::find(request('ids'));

        foreach ($fees as $fee) {
            $fee->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function feeRecord()
    {
        $student = Student::where('user_id', Auth::user()->id)->first();
        $feeRecords = Fee::with('course', 'student')->whereHas('course', function ($query) use ($student){$query->whereIn('id', $student->courses->pluck('id'));})->get();
        // dd($feeRecords);

        return view('frontend.fees.feerecord', compact('feeRecords'));
    }
}
