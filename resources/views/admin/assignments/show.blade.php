@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.assignment.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.assignments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.assignment.fields.id') }}
                        </th>
                        <td>
                            {{ $assignment->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.assignment.fields.course') }}
                        </th>
                        <td>
                            {{ $assignment->course->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.assignment.fields.title') }}
                        </th>
                        <td>
                            {{ $assignment->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.assignment.fields.description') }}
                        </th>
                        <td>
                            {!! $assignment->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.assignment.fields.image') }}
                        </th>
                        <td>
                            @foreach($assignment->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.assignment.fields.pdf') }}
                        </th>
                        <td>
                            @foreach($assignment->pdf as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.assignment.fields.points') }}
                        </th>
                        <td>
                            {{ $assignment->points }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.assignment.fields.student') }}
                        </th>
                        <td>
                            @foreach($assignment->students as $key => $student)
                                <span class="label label-info">{{ $student->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.assignments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#assignment_assign_assignments" role="tab" data-toggle="tab">
                {{ trans('cruds.assignAssignment.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="assignment_assign_assignments">
            @includeIf('admin.assignments.relationships.assignmentAssignAssignments', ['assignAssignments' => $assignment->assignmentAssignAssignments])
        </div>
    </div>
</div>

@endsection