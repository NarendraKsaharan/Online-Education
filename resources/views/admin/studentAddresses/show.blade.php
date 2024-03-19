@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.studentAddress.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.student-addresses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.studentAddress.fields.id') }}
                        </th>
                        <td>
                            {{ $studentAddress->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentAddress.fields.student') }}
                        </th>
                        <td>
                            {{ $studentAddress->student->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentAddress.fields.name') }}
                        </th>
                        <td>
                            {{ $studentAddress->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentAddress.fields.address') }}
                        </th>
                        <td>
                            {{ $studentAddress->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentAddress.fields.country') }}
                        </th>
                        <td>
                            {{ $studentAddress->country->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentAddress.fields.state') }}
                        </th>
                        <td>
                            {{ $studentAddress->state->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentAddress.fields.city') }}
                        </th>
                        <td>
                            {{ $studentAddress->city->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentAddress.fields.pincode') }}
                        </th>
                        <td>
                            {{ $studentAddress->pincode }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.student-addresses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection