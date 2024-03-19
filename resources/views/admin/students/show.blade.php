@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.student.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.students.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.id') }}
                        </th>
                        <td>
                            {{ $student->id }}
                        </td>
                        <th>
                            {{ trans('cruds.student.fields.user') }}
                        </th>
                        <td>
                            {{ $student->user->name ?? '' }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.course') }}
                        </th>
                        <td>
                            @foreach($student->courses as $key => $course)
                                <span class="label label-info">{{ $course->title }}</span>
                            @endforeach
                        </td>
                        <th>
                            {{ trans('cruds.student.fields.name') }}
                        </th>
                        <td>
                            {{ $student->name }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.email') }}
                        </th>
                        <td>
                            {{ $student->email }}
                        </td>
                        <th>
                            {{ trans('cruds.student.fields.phone') }}
                        </th>
                        <td>
                            {{ $student->phone }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.gender') }}
                        </th>
                        <td>
                            {{ App\Models\Student::GENDER_RADIO[$student->gender] ?? '' }}
                        </td>
                        <th>
                            {{ trans('cruds.student.fields.profile_image') }}
                        </th>
                        <td>
                            @if($student->profile_image)
                                <a href="{{ $student->profile_image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $student->profile_image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.join_date') }}
                        </th>
                        <td>
                            {{ $student->join_date }}
                        </td>
                        <th>
                            {{ trans('cruds.student.fields.leave_date') }}
                        </th>
                        <td>
                            {{ $student->leave_date }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#student_student_addresses" role="tab" data-toggle="tab">
                {{ trans('cruds.studentAddress.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#student_fees" role="tab" data-toggle="tab">
                {{ trans('cruds.fee.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#student_student_educations" role="tab" data-toggle="tab">
                {{ trans('cruds.studentEducation.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#student_assignments" role="tab" data-toggle="tab">
                {{ trans('cruds.assignment.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#student_assign_assignments" role="tab" data-toggle="tab">
                {{ trans('cruds.assignAssignment.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#student_fee_records" role="tab" data-toggle="tab">
                {{ trans('cruds.feeRecord.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="student_student_addresses">
            @includeIf('admin.students.relationships.studentStudentAddresses', ['studentAddresses' => $student->studentStudentAddresses])
        </div>
        <div class="tab-pane" role="tabpanel" id="student_fees">
            @includeIf('admin.students.relationships.studentFees', ['courses' => $student->courses])
        </div>
        <div class="tab-pane" role="tabpanel" id="student_student_educations">
            @includeIf('admin.students.relationships.studentStudentEducations', ['studentEducations' => $student->studentStudentEducations])
        </div>
        <div class="tab-pane" role="tabpanel" id="student_assignments">
            @includeIf('admin.students.relationships.studentAssignments', ['assignments' => $student->studentAssignments])
        </div>
        <div class="tab-pane" role="tabpanel" id="student_assign_assignments">
            @includeIf('admin.students.relationships.studentAssignAssignments', ['assignAssignments' => $student->studentAssignAssignments])
        </div>
        <div class="tab-pane" role="tabpanel" id="student_fee_records">
            @includeIf('admin.students.relationships.studentFeeRecords', ['feeRecords' => $student->studentFeeRecords])
        </div>
    </div>
</div>

@endsection