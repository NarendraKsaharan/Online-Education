@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.studentAddress.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.student-addresses.update", [$studentAddress->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="student_id">{{ trans('cruds.studentAddress.fields.student') }}</label>
                            <select class="form-control select2" name="student_id" id="student_id">
                                @foreach($students as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('student_id') ? old('student_id') : $studentAddress->student->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('student'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('student') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.studentAddress.fields.student_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.studentAddress.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $studentAddress->name) }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.studentAddress.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="address">{{ trans('cruds.studentAddress.fields.address') }}</label>
                            <textarea class="form-control" name="address" id="address">{{ old('address', $studentAddress->address) }}</textarea>
                            @if($errors->has('address'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('address') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.studentAddress.fields.address_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="country_id">{{ trans('cruds.studentAddress.fields.country') }}</label>
                            <select class="form-control select2" name="country_id" id="country_id" required>
                                @foreach($countries as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('country_id') ? old('country_id') : $studentAddress->country->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('country'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('country') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.studentAddress.fields.country_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="state_id">{{ trans('cruds.studentAddress.fields.state') }}</label>
                            <select class="form-control select2" name="state_id" id="state_id" required>
                                @foreach($states as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('state_id') ? old('state_id') : $studentAddress->state->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('state'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('state') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.studentAddress.fields.state_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="city_id">{{ trans('cruds.studentAddress.fields.city') }}</label>
                            <select class="form-control select2" name="city_id" id="city_id" required>
                                @foreach($cities as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('city_id') ? old('city_id') : $studentAddress->city->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('city'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('city') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.studentAddress.fields.city_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="pincode">{{ trans('cruds.studentAddress.fields.pincode') }}</label>
                            <input class="form-control" type="text" name="pincode" id="pincode" value="{{ old('pincode', $studentAddress->pincode) }}">
                            @if($errors->has('pincode'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('pincode') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.studentAddress.fields.pincode_helper') }}</span>
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