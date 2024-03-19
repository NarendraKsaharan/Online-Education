@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.feeRecord.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.fee-records.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.feeRecord.fields.id') }}
                        </th>
                        <td>
                            {{ $feeRecord->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.feeRecord.fields.course') }}
                        </th>
                        <td>
                            @foreach($feeRecord->courses as $key => $course)
                                <span class="label label-info">{{ $course->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.feeRecord.fields.student') }}
                        </th>
                        <td>
                            @foreach($feeRecord->students as $key => $student)
                                <span class="label label-info">{{ $student->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.feeRecord.fields.fee') }}
                        </th>
                        <td>
                            {{ $feeRecord->fee }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.feeRecord.fields.balance') }}
                        </th>
                        <td>
                            {{ $feeRecord->balance }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.feeRecord.fields.join_date') }}
                        </th>
                        <td>
                            {{ $feeRecord->join_date }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.fee-records.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection