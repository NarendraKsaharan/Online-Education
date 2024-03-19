@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.fee.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.fees.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.fee.fields.id') }}
                        </th>
                        <td>
                            {{ $fee->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fee.fields.course') }}
                        </th>
                        <td>
                            {{ $fee->course->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fee.fields.student') }}
                        </th>
                        <td>
                            {{ $fee->student->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fee.fields.amount') }}
                        </th>
                        <td>
                            {{ $fee->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fee.fields.remark') }}
                        </th>
                        <td>
                            {{ $fee->remark }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fee.fields.payment_date') }}
                        </th>
                        <td>
                            {{ $fee->payment_date }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.fees.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection