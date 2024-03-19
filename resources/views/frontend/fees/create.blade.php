@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.fee.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.fees.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="course_id">{{ trans('cruds.fee.fields.course') }}</label>
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
                            <span class="help-block">{{ trans('cruds.fee.fields.course_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="student_id">{{ trans('cruds.fee.fields.student') }}</label>
                            <select class="form-control select2" name="student_id" id="student_id" required>
                                @foreach($students as $id => $entry)
                                    <option value="{{ $id }}" {{ old('student_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('student'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('student') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.fee.fields.student_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="amount">{{ trans('cruds.fee.fields.amount') }}</label>
                            <input class="form-control" type="number" name="amount" id="amount" value="{{ old('amount', '') }}" step="0.01" required>
                            @if($errors->has('amount'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('amount') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.fee.fields.amount_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="remark">{{ trans('cruds.fee.fields.remark') }}</label>
                            <textarea class="form-control" name="remark" id="remark" required>{{ old('remark') }}</textarea>
                            @if($errors->has('remark'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('remark') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.fee.fields.remark_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="payment_date">{{ trans('cruds.fee.fields.payment_date') }}</label>
                            <input class="form-control date" type="text" name="payment_date" id="payment_date" value="{{ old('payment_date') }}" required>
                            @if($errors->has('payment_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('payment_date') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.fee.fields.payment_date_helper') }}</span>
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