@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.exam.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.exams.update", [$exam->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="course_id">{{ trans('cruds.exam.fields.course') }}</label>
                            <select class="form-control select2" name="course_id" id="course_id" required>
                                @foreach($courses as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('course_id') ? old('course_id') : $exam->course->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('course'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('course') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.exam.fields.course_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="title">{{ trans('cruds.exam.fields.title') }}</label>
                            <input class="form-control" type="text" name="title" id="title" value="{{ old('title', $exam->title) }}" required>
                            @if($errors->has('title'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.exam.fields.title_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.exam.fields.status') }}</label>
                            <select class="form-control" name="status" id="status" required>
                                <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Exam::STATUS_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('status', $exam->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.exam.fields.status_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="plans">{{ trans('cruds.exam.fields.plan') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2" name="plans[]" id="plans" multiple required>
                                @foreach($plans as $id => $plan)
                                    <option value="{{ $id }}" {{ (in_array($id, old('plans', [])) || $exam->plans->contains($id)) ? 'selected' : '' }}>{{ $plan }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('plans'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('plans') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.exam.fields.plan_helper') }}</span>
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