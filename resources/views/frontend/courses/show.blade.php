@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.course.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.courses.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.course.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $course->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.course.fields.title') }}
                                    </th>
                                    <td>
                                        {{ $course->title }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.course.fields.status') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Course::STATUS_SELECT[$course->status] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.course.fields.description') }}
                                    </th>
                                    <td>
                                        {!! $course->description !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.course.fields.image') }}
                                    </th>
                                    <td>
                                        @foreach($course->image as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                                <img src="{{ $media->getUrl('thumb') }}">
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.course.fields.pdf') }}
                                    </th>
                                    <td>
                                        @foreach($course->pdf as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.course.fields.fee') }}
                                    </th>
                                    <td>
                                        {{ $course->fee }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.course.fields.fee_type') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Course::FEE_TYPE_SELECT[$course->fee_type] ?? '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.courses.index') }}">
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