@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.studentEducation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.student-educations.update", [$studentEducation->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="student_id">{{ trans('cruds.studentEducation.fields.student') }}</label>
                        <select class="form-control select2 {{ $errors->has('student') ? 'is-invalid' : '' }}" name="student_id" id="student_id" required>
                            @foreach($students as $id => $entry)
                                <option value="{{ $id }}" {{ (old('student_id') ? old('student_id') : $studentEducation->student->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('student'))
                            <span class="text-danger">{{ $errors->first('student') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.studentEducation.fields.student_helper') }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="class">{{ trans('cruds.studentEducation.fields.class') }}</label>
                        <input class="form-control {{ $errors->has('class') ? 'is-invalid' : '' }}" type="text" name="class" id="class" value="{{ old('class', $studentEducation->class) }}" required>
                        @if($errors->has('class'))
                            <span class="text-danger">{{ $errors->first('class') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.studentEducation.fields.class_helper') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="university">{{ trans('cruds.studentEducation.fields.university') }}</label>
                        <textarea class="form-control {{ $errors->has('university') ? 'is-invalid' : '' }}" name="university" id="university" required>{{ old('university', $studentEducation->university) }}</textarea>
                        @if($errors->has('university'))
                            <span class="text-danger">{{ $errors->first('university') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.studentEducation.fields.university_helper') }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="passing_year">{{ trans('cruds.studentEducation.fields.passing_year') }}</label>
                        <input class="form-control date {{ $errors->has('passing_year') ? 'is-invalid' : '' }}" type="text" name="passing_year" id="passing_year" value="{{ old('passing_year', $studentEducation->passing_year) }}" required>
                        @if($errors->has('passing_year'))
                            <span class="text-danger">{{ $errors->first('passing_year') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.studentEducation.fields.passing_year_helper') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="percentage">{{ trans('cruds.studentEducation.fields.percentage') }}</label>
                        <input class="form-control {{ $errors->has('percentage') ? 'is-invalid' : '' }}" type="text" name="percentage" id="percentage" value="{{ old('percentage', $studentEducation->percentage) }}" required>
                        @if($errors->has('percentage'))
                            <span class="text-danger">{{ $errors->first('percentage') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.studentEducation.fields.percentage_helper') }}</span>
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