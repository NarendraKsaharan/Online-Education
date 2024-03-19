@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.feeRecord.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.fee-records.update", [$feeRecord->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="courses">{{ trans('cruds.feeRecord.fields.course') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2" name="courses[]" id="courses" multiple>
                                @foreach($courses as $id => $course)
                                    <option value="{{ $id }}" {{ (in_array($id, old('courses', [])) || $feeRecord->courses->contains($id)) ? 'selected' : '' }}>{{ $course }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('courses'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('courses') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.feeRecord.fields.course_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="students">{{ trans('cruds.feeRecord.fields.student') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2" name="students[]" id="students" multiple required>
                                @foreach($students as $id => $student)
                                    <option value="{{ $id }}" {{ (in_array($id, old('students', [])) || $feeRecord->students->contains($id)) ? 'selected' : '' }}>{{ $student }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('students'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('students') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.feeRecord.fields.student_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="fee">{{ trans('cruds.feeRecord.fields.fee') }}</label>
                            <input class="form-control" type="number" name="fee" id="fee" value="{{ old('fee', $feeRecord->fee) }}" step="0.01" required>
                            @if($errors->has('fee'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('fee') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.feeRecord.fields.fee_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="balance">{{ trans('cruds.feeRecord.fields.balance') }}</label>
                            <input class="form-control" type="number" name="balance" id="balance" value="{{ old('balance', $feeRecord->balance) }}" step="0.01">
                            @if($errors->has('balance'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('balance') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.feeRecord.fields.balance_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="join_date">{{ trans('cruds.feeRecord.fields.join_date') }}</label>
                            <input class="form-control date" type="text" name="join_date" id="join_date" value="{{ old('join_date', $feeRecord->join_date) }}">
                            @if($errors->has('join_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('join_date') }}
                                </div>
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

        </div>
    </div>
</div>
@endsection