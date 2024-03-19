@extends('layouts.admin')

@section('content')
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
                                <select name="student_id[]" id="student_id" class="form-control select2" multiple required>
                                    <option value="0">Select Student</option>
                                    @foreach($allStudent as $id => $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach 
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="assignments">Assign Assignment</label>
                                <select name="assignments_id[]" id="assignments" class="form-control select2" multiple required>
                                    <option value="0">Select Assignment</option>
                                    @foreach($allAssignment as $id => $item)
                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach 
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1 mt-4">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                        <div class="col-md-1 mt-4">
                            <a href="{{ route('admin.assign-task') }}" class="btn btn-secondary">Clear</a> 
                        </div>
                    </div>
                </form>
            </fieldset>
        </div>
    </div>
</div>


@endsection

@section('scripts')

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

<script>
    $(document).ready(function(){
        $('#course_id').select2();
        
        $('#course_id').on('select2:select', function(){
            courseId = $(this).val();
            // alert(courseId);

            $.ajax({
                url: "{{route('admin.get-assignment')}}",
                method: 'GET',
                data: {'course_id': courseId},
                success: function(res) {
                    // console.log(res);
                    $('#assignments').html(res);
                },
                error: function(re) {
                    alert("Something went wrong with your JS code...");
                }
            });
        });
    });
</script>

@endsection