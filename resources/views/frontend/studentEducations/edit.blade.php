@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.studentEducation.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.student-educations.update", [$studentEducation->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="student_id">{{ trans('cruds.studentEducation.fields.student') }}</label>
                            <select class="form-control select2" name="student_id" id="student_id" required>
                                @foreach($students as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('student_id') ? old('student_id') : $studentEducation->student->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('student'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('student') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.studentEducation.fields.student_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="class">{{ trans('cruds.studentEducation.fields.class') }}</label>
                            <input class="form-control" type="text" name="class" id="class" value="{{ old('class', $studentEducation->class) }}" required>
                            @if($errors->has('class'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('class') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.studentEducation.fields.class_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="university">{{ trans('cruds.studentEducation.fields.university') }}</label>
                            <textarea class="form-control" name="university" id="university" required>{{ old('university', $studentEducation->university) }}</textarea>
                            @if($errors->has('university'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('university') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.studentEducation.fields.university_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="passing_year">{{ trans('cruds.studentEducation.fields.passing_year') }}</label>
                            <input class="form-control date" type="text" name="passing_year" id="passing_year" value="{{ old('passing_year', $studentEducation->passing_year) }}" required>
                            @if($errors->has('passing_year'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('passing_year') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.studentEducation.fields.passing_year_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="percentage">{{ trans('cruds.studentEducation.fields.percentage') }}</label>
                            <input class="form-control" type="text" name="percentage" id="percentage" value="{{ old('percentage', $studentEducation->percentage) }}" required>
                            @if($errors->has('percentage'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('percentage') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.studentEducation.fields.percentage_helper') }}</span>
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