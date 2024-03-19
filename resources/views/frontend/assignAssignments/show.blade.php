@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.assignAssignment.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.assign-assignments.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.assignAssignment.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $assignAssignment->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.assignAssignment.fields.course') }}
                                    </th>
                                    <td>
                                        {{ $assignAssignment->course->title ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.assignAssignment.fields.student') }}
                                    </th>
                                    <td>
                                        @foreach($assignAssignment->students as $key => $student)
                                            <span class="label label-info">{{ $student->name }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.assignAssignment.fields.assignment') }}
                                    </th>
                                    <td>
                                        @foreach($assignAssignment->assignments as $key => $assignment)
                                            <span class="label label-info">{{ $assignment->title }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.assign-assignments.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection