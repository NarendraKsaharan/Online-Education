@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.feeRecord.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.fee-records.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="courses">{{ trans('cruds.feeRecord.fields.course') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('courses') ? 'is-invalid' : '' }}" name="courses[]" id="courses" multiple>
                    @foreach($courses as $id => $course)
                        <option value="{{ $id }}" {{ in_array($id, old('courses', [])) ? 'selected' : '' }}>{{ $course }}</option>
                    @endforeach
                </select>
                @if($errors->has('courses'))
                    <span class="text-danger">{{ $errors->first('courses') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.feeRecord.fields.course_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="students">{{ trans('cruds.feeRecord.fields.student') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('students') ? 'is-invalid' : '' }}" name="students[]" id="students" multiple required>
                    @foreach($students as $id => $student)
                        <option value="{{ $id }}" {{ in_array($id, old('students', [])) ? 'selected' : '' }}>{{ $student }}</option>
                    @endforeach
                </select>
                @if($errors->has('students'))
                    <span class="text-danger">{{ $errors->first('students') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.feeRecord.fields.student_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="fee">{{ trans('cruds.feeRecord.fields.fee') }}</label>
                <input class="form-control {{ $errors->has('fee') ? 'is-invalid' : '' }}" type="number" name="fee" id="fee" value="{{ old('fee', '') }}" step="0.01" required>
                @if($errors->has('fee'))
                    <span class="text-danger">{{ $errors->first('fee') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.feeRecord.fields.fee_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="balance">{{ trans('cruds.feeRecord.fields.balance') }}</label>
                <input class="form-control {{ $errors->has('balance') ? 'is-invalid' : '' }}" type="number" name="balance" id="balance" value="{{ old('balance', '') }}" step="0.01">
                @if($errors->has('balance'))
                    <span class="text-danger">{{ $errors->first('balance') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.feeRecord.fields.balance_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="join_date">{{ trans('cruds.feeRecord.fields.join_date') }}</label>
                <input class="form-control date {{ $errors->has('join_date') ? 'is-invalid' : '' }}" type="text" name="join_date" id="join_date" value="{{ old('join_date') }}">
                @if($errors->has('join_date'))
                    <span class="text-danger">{{ $errors->first('join_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.feeRecord.fields.join_date_helper') }}</span>
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