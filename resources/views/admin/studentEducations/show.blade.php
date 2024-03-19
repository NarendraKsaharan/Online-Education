@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.studentEducation.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.student-educations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.studentEducation.fields.id') }}
                        </th>
                        <td>
                            {{ $studentEducation->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentEducation.fields.student') }}
                        </th>
                        <td>
                            {{ $studentEducation->student->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentEducation.fields.class') }}
                        </th>
                        <td>
                            {{ $studentEducation->class }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentEducation.fields.university') }}
                        </th>
                        <td>
                            {{ $studentEducation->university }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentEducation.fields.passing_year') }}
                        </th>
                        <td>
                            {{ $studentEducation->passing_year }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentEducation.fields.percentage') }}
                        </th>
                        <td>
                            {{ $studentEducation->percentage }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.student-educations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection