@extends('layouts.admin')

@section('styles')
<style>
    .form-container {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    border: 1px solid #ccc; 
    z-index: 9999;
    }

    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); 
        z-index: 9998; 
        backdrop-filter: blur(5px); 
        display: none; 
    }
  </style>
@endsection 

@section('content')
@can('fee_create')
    <!-- <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <button type="button" class="btn btn-primary openPopupBtn" id="openPopupBtn">Collect Fee</button>
        </div>
    </div> -->
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.fee.title_singular') }} {{ trans('global.list') }}
        <div class="form-group">
            <fieldset class="border p-2">
                <legend class="w-auto font-weight-bold">Search</legend>
                <form action="{{ route('admin.add-fee') }}" method="GET">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="course">Course</label>
                                <select name="course_id" id="course_id" class="form-control">
                                    <option value="0">Select Course</option>
                                    @foreach($allCourse as $id => $item)
                                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="student">Student</label>
                                <select name="student_id" id="student_id" class="form-control">
                                        <option value="0">Select Student</option> 
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                        </div>
                        <div class="col-md-1 mt-4">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                        <div class="col-md-1 mt-4">
                            <a href="{{ route('admin.add-fee') }}" class="btn btn-secondary">Clear</a> 
                        </div>
                    </div>
                </form>
            </fieldset>
        </div>
        <div class="table-responsive">
        @if(isset($students) && $students->count() > 0)
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Course Fee Type</th>
                        <th>Fee</th>
                        <th>Balance</th>
                        <th>Payment Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td rowspan="{{ count($student->courses) + 1 }}">{{ $student->id }}</td>
                            <td rowspan="{{ count($student->courses) + 1 }}">{{ $student->name }}</td>
                        </tr>
                        
                        @php
                            $totalFee = 0;
                        @endphp
                            
                            @foreach($student->courses as $course)
                            @php
                                $totalFee += $course->fee;
                                $alreadyPaidFee = 0;

                                foreach($student->studentFees as $fee){
                                    if($fee->course_id === $course->id){
                                        $alreadyPaidFee += $fee->amount;
                                    }
                                }
                                $balance = $course->fee - $alreadyPaidFee;
                            @endphp
                            <tr>
                                <td>{{ $course->title }}</td>
                                <td>{{ ($course->fee_type == 1)? 'monthly' : 'fixed' }}</td>
                                <td>{{ $course->fee }}</td>
                                <td>{{ $balance }}</td>
                                <td>{{ $fee->payment_date }}</td>
                                <td>
                                <div class="col-lg-12">
                                    <button type="button" class="btn btn-primary openPopupBtn" id="openPopupBtn" data-course="{{ $course->title }}" data-course-id="{{ $course->id }}" data-student-name="{{ $student->name }}" data-student-id="{{ $student->id }}" data-fee="{{ $course->fee }}" data-balance="{{ $balance }}" data-fee-type="{{ $course->fee_type }}">Collect Fee</button>
                                </div>
                                </td>
                            </tr>
                            @php
                                
                            @endphp
                        @endforeach

                        <tr>
                            <td colspan="2">Total Fee</td>
                            <td colspan="4">{{ $totalFee }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
            @else
                <p>No records found.</p>
            @endif 
        </div>
    </div>
    </div>
</div>



<div class="card-body">
    <div class="overlay" id="overlay"></div>
    <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Fee">
        <div class="form-container" id="formContainer" style="width: 50%; margin: auto;">
            <h2>Student Fee</h2>
            <form method="POST" action="{{ route("admin.fees-store") }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="course">Course</label>
                            <input type="hidden" name="course_id" id="courseId" value="">
                            <input type="text" name="course" id="course" value="" readonly class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="course">Course Fee Type</label>
                            <input type="text" name="fee_type" id="feeType" value="" readonly class="form-control">
                        </div>
                    </div>

                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="student_id">Name</label>
                            <input type="hidden" name="student_id" id="studentId" value="">
                            <input type="text" class="form-control" name="student_name" id="studentName" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="student_id">Total Fee</label>
                            <input type="text" id="fee" class="form-control" value="" readonly>
                        </div>
                    </div>

                </div>    
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="balance">Balance</label>
                            <input type="text" id="balance" class="form-control" value="" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required" for="amount">Amount</label>
                            <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount', '') }}" step="0.01" required>
                            @if($errors->has('amount'))
                                <span class="text-danger">{{ $errors->first('amount') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required" for="payment_date">Payment Date</label>
                            <input class="form-control date {{ $errors->has('payment_date') ? 'is-invalid' : '' }}" type="text" name="payment_date" id="payment_date" value="{{ old('payment_date') }}" required>
                            @if($errors->has('payment_date'))
                                <span class="text-danger">{{ $errors->first('payment_date') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required" for="remark">Remark</label>
                            <textarea class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" name="remark" id="remark" required>{{ old('remark') }}</textarea>
                            @if($errors->has('remark'))
                                <span class="text-danger">{{ $errors->first('remark') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="button-container text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" id="closeFormBtn" class="btn btn-secondary">Close</button>
                </div>
            </form>
        </div>
    </table>
</div>




@endsection
@section('scripts')

<!-- <script>
    $(document).ready(function() {
    $("#openPopupBtn").click(function() {
        $("#formContainer").fadeIn(500);
    });

    $("#closeFormBtn").click(function() {
        $("#formContainer").fadeOut(500);
    });
    });
</script> -->

<script>
    $(document).ready(function(){
        $('.openPopupBtn').click(function(){
            courseId = $(this).data('course-id');
            studentId = $(this).data('student-id');
            course = $(this).data('course');
            studentName = $(this).data('student-name');
            fee = $(this).data('fee');
            feeType = $(this).data('fee-type');
            balance = $(this).data('balance');

            $('#courseId').val(courseId);
            $('#studentId').val(studentId);
            $('#course').val(course);
            if (feeType === 1) {
                $('#feeType').val('fixed');
            } else {
                $('#feeType').val('monthly');
            }
            $('#studentName').val(studentName);
            $('#fee').val(fee);
            $('#balance').val(balance);
            $("#formContainer").fadeIn(500);
            $('#overlay').fadeIn(500);

        });


        $("#closeFormBtn").click(function() {
            $("#formContainer").fadeOut(500);
            $('#overlay').fadeOut(500);
        });

        //clear button
        $("#clearBtn").click(function() {
            // Clear search input fields
            $("input[name='name']").val('');
            $("input[name='email']").val('');
            $("input[name='course_title']").val('');

            // Clear DataTable search and sorting
            var table = $('.datatable-Fee').DataTable();
            table.search('').draw();
            table.order([]).draw();
        });
    });
</script>

<script>
    $(document).ready(function(){
        $('#course_id').select2();

        $('#course_id').on('select2:select', function(){
            courseId = $(this).val();
            // alert(courseId);

            $.ajax({
                url: "{{route('admin.get-student')}}",
                method: 'GET',
                data: {'course_id': courseId},
                success: function(res) {
                    // console.log("sbdchjbsdhjcbsdk");
                    $('#student_id').html(res);
                },
                error: function(re) {
                    alert("Something went wrong with your JS code...");
                }
            });
        });
    });
</script>

@endsection