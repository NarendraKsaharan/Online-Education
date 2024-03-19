@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.assignAssignment.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.assign-assignments.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="course_id">{{ trans('cruds.assignAssignment.fields.course') }}</label>
                        <select class="form-control select2 {{ $errors->has('course') ? 'is-invalid' : '' }}" name="course_id" id="course_id" required>
                            @foreach($courses as $id => $entry)
                                <option value="{{ $id }}" {{ old('course_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('course'))
                            <span class="text-danger">{{ $errors->first('course') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.assignAssignment.fields.course_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="students">{{ trans('cruds.assignAssignment.fields.student') }}</label>
                        <select class="form-control select2 {{ $errors->has('students') ? 'is-invalid' : '' }}" name="students[]" id="students" multiple required>
                            @foreach($students as $id => $student)
                            <option value="{{ $id }}" {{ in_array($id, old('students', [])) ? 'selected' : '' }}>{{ $student }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('students'))
                        <span class="text-danger">{{ $errors->first('students') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.assignAssignment.fields.student_helper') }}</span>
                        <div style="padding-bottom: 4px">
                            <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                            <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="assignments">{{ trans('cruds.assignAssignment.fields.assignment') }}</label>
                        <select class="form-control select2 {{ $errors->has('assignments') ? 'is-invalid' : '' }}" name="assignments[]" id="assignments" multiple required>
                            @foreach($assignments as $id => $assignment)
                            <option value="{{ $id }}" {{ in_array($id, old('assignments', [])) ? 'selected' : '' }}>{{ $assignment }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('assignments'))
                        <span class="text-danger">{{ $errors->first('assignments') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.assignAssignment.fields.assignment_helper') }}</span>
                        <div style="padding-bottom: 4px">
                            <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                            <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
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
                    $('#students').html(res);
                },
                error: function(re) {
                    alert("Something went wrong with your JS code...");
                }
            });
        });
    });
</script>


@endsection