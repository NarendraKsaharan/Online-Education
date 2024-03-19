<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\FeeRecord;
use App\Models\Student;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FeeRecordController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('fee_record_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $feeRecords = FeeRecord::with(['courses', 'students'])->get();

        $courses = Course::get();

        $students = Student::get();

        return view('frontend.feeRecords.index', compact('courses', 'feeRecords', 'students'));
    }

    public function show(FeeRecord $feeRecord)
    {
        abort_if(Gate::denies('fee_record_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $feeRecord->load('courses', 'students');

        return view('frontend.feeRecords.show', compact('feeRecord'));
    }
}
