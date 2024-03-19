<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class FeeController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('fee_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Fee::with(['course', 'student'])->select(sprintf('%s.*', (new Fee)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'fee_show';
                $editGate      = 'fee_edit';
                $deleteGate    = 'fee_delete';
                $crudRoutePart = 'fees';

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

            $table->addColumn('student_name', function ($row) {
                return $row->student ? $row->student->name : '';
            });

            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'course', 'student']);

            return $table->make(true);
        }

        $courses  = Course::get();
        $students = Student::get();

        return view('admin.fees.index', compact('courses', 'students'));
    }

    public function create()
    {
        abort_if(Gate::denies('fee_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $students = Student::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.fees.create', compact('courses', 'students'));
    }

    public function store(StoreFeeRequest $request)
    {
        $fee = Fee::create($request->all());
        $popupForm = $request->input('source');

        if ($popupForm === 'popupForm') {
            return redirect()->back();
        } else {
            return redirect()->route('admin.fees.index');
        }
    }

    public function edit(Fee $fee)
    {
        abort_if(Gate::denies('fee_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $students = Student::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $fee->load('course', 'student');

        return view('admin.fees.edit', compact('courses', 'fee', 'students'));
    }

    public function update(UpdateFeeRequest $request, Fee $fee)
    {
        $fee->update($request->all());

        return redirect()->route('admin.fees.index');
    }

    public function show(Fee $fee)
    {
        abort_if(Gate::denies('fee_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fee->load('course', 'student');

        return view('admin.fees.show', compact('fee'));
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

    public function addFee(Request $request)
    {
        $allCourse = Course::all();
        $allStudent = Student::all();
        
        $query = Student::query();

        // $course = Course::where('id', 1)->first();
        // $students = $course->courseStudents()->get();
        // dd($students);
        if ($request->has('course_id')) {
            $course_id = $request->input('course_id');
            if ($course_id != 0) {
                $query->whereHas('courses', function ($query) use ($course_id) {
                    $query->where('id', $course_id);
                });
            }
        }
    
        if ($request->has('student_id')) {
            $student_id = $request->input('student_id');
            if ($student_id != 0) {
                $query->where('id', $student_id);
            }
        }
    
        if ($request->has('email')) {
            $email = $request->input('email');
            if (!empty($email)) {
                $query->where('email', $email);
            }
        }

        if (!$request->filled('course_id') && !$request->filled('student_id') && !$request->filled('email')) {
            $query->where('id', 0);
        }

        $students = $query->with('courses', 'studentFees')->get(); 
        // dd($students);
        return view('admin.fees.addfee', compact('students', 'allCourse', 'allStudent'));
    }

    // public function addFee(Request $request)
    // {
    //     $allCourse = Course::all();
    //     $allStudent = Student::all();
        
    //     $students = [];
        
    //     $courseId = $request->input('course_id');
    //     $studentId = $request->input('student_id');
    //     $email = $request->input('email');
        
    //     $query = Student::query();
    //     if ($courseId != 0) {
    //         $query->whereHas('courses', function ($q) use ($courseId) {
    //             $q->where('id', $courseId);
    //         });
    //     }
    
    //     if ($studentId != 0) {
    //         $query->where('id', $studentId);
    //     }

    //     if ($email) {
    //         $query->where('email', $email);
    //     }

    //     if ($courseId  && $studentId) {
    //         $student = $query->with(['courses' => function ($q) use ($courseId) { $q->where('id', $courseId);}, 'studentFees'])->first();
    //     } else {
    //             $student = $query->with('courses', 'studentFees')->get();
    //         }
    //         $students = $query->with('courses', 'studentFees')->get(); 
    //     // dd($student);
    //     return view('admin.fees.addfee', compact('students', 'allCourse', 'allStudent'));
    // }


    public function feeRecord()
    {
        $feeRecords = Fee::with('course', 'student')->get();
        // dd($feeRecords);

        return view('admin.fees.feerecord', compact('feeRecords'));
    }

    public function getStudent(Request $request){
        $courseId = $request->input('course_id');
        $course = Course::where('id', $courseId)->first();
        $students = $course->courseStudents()->get();
        $html = '<option value="">Select Student</option>';

        foreach ($students as $student) {
            $html.= '<option value="'.$student->id.'">'.$student->name.'</option>';
        }
        return $html;
    }
}






// FeeController.php

// use App\Models\Student;

// public function addFee(Request $request)
// {
//     $query = Student::query()->with(['courses', 'studentFees']);

//     if ($request->filled('name')) {
//         $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
//     }

//     if ($request->filled('email')) {
//         $query->where('email', 'LIKE', '%' . $request->input('email') . '%');
//     }

//     if (!$request->filled('name') && !$request->filled('email')) {
//         $query->where('id', 0);
//     }

//     $students = $query->get();

//     return view('admin.fees.addfee', compact('students'));
// }

