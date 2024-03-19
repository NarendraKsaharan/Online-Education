@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.student.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.students.index') }}">
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
                                </tr>
                                <tr>
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
                                </tr>
                                <tr>
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
                                </tr>
                                <tr>
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
                                </tr>
                                <tr>
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
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.student.fields.leave_date') }}
                                    </th>
                                    <td>
                                        {{ $student->leave_date }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.students.index') }}">
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