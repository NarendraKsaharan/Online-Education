@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.assignAssignment.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.assign-assignments.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="course_id">{{ trans('cruds.assignAssignment.fields.course') }}</label>
                            <select class="form-control select2" name="course_id" id="course_id" required>
                                @foreach($courses as $id => $entry)
                                    <option value="{{ $id }}" {{ old('course_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('course'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('course') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.assignAssignment.fields.course_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="students">{{ trans('cruds.assignAssignment.fields.student') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2" name="students[]" id="students" multiple required>
                                @foreach($students as $id => $student)
                                    <option value="{{ $id }}" {{ in_array($id, old('students', [])) ? 'selected' : '' }}>{{ $student }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('students'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('students') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.assignAssignment.fields.student_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="assignments">{{ trans('cruds.assignAssignment.fields.assignment') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2" name="assignments[]" id="assignments" multiple required>
                                @foreach($assignments as $id => $assignment)
                                    <option value="{{ $id }}" {{ in_array($id, old('assignments', [])) ? 'selected' : '' }}>{{ $assignment }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('assignments'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('assignments') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.assignAssignment.fields.assignment_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection