@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.fee.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.fees.update", [$fee->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="course_id">{{ trans('cruds.fee.fields.course') }}</label>
                        <select class="form-control select2 {{ $errors->has('course') ? 'is-invalid' : '' }}" name="course_id" id="course_id" required>
                            @foreach($courses as $id => $entry)
                                <option value="{{ $id }}" {{ (old('course_id') ? old('course_id') : $fee->course->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('course'))
                            <span class="text-danger">{{ $errors->first('course') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.fee.fields.course_helper') }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="student_id">{{ trans('cruds.fee.fields.student') }}</label>
                        <select class="form-control select2 {{ $errors->has('student') ? 'is-invalid' : '' }}" name="student_id" id="student_id" required>
                            @foreach($students as $id => $entry)
                                <option value="{{ $id }}" {{ (old('student_id') ? old('student_id') : $fee->student->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('student'))
                            <span class="text-danger">{{ $errors->first('student') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.fee.fields.student_helper') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="amount">{{ trans('cruds.fee.fields.amount') }}</label>
                        <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount', $fee->amount) }}" step="0.01" required>
                        @if($errors->has('amount'))
                            <span class="text-danger">{{ $errors->first('amount') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.fee.fields.amount_helper') }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="payment_date">{{ trans('cruds.fee.fields.payment_date') }}</label>
                        <input class="form-control date {{ $errors->has('payment_date') ? 'is-invalid' : '' }}" type="text" name="payment_date" id="payment_date" value="{{ old('payment_date', $fee->payment_date) }}" required>
                        @if($errors->has('payment_date'))
                            <span class="text-danger">{{ $errors->first('payment_date') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.fee.fields.payment_date_helper') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="remark">{{ trans('cruds.fee.fields.remark') }}</label>
                        <textarea class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" name="remark" id="remark" required>{{ old('remark', $fee->remark) }}</textarea>
                        @if($errors->has('remark'))
                            <span class="text-danger">{{ $errors->first('remark') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.fee.fields.remark_helper') }}</span>
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

@endsection