@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.exam.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.exams.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.exam.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $exam->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.exam.fields.course') }}
                                    </th>
                                    <td>
                                        {{ $exam->course->title ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.exam.fields.title') }}
                                    </th>
                                    <td>
                                        {{ $exam->title }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.exam.fields.status') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Exam::STATUS_SELECT[$exam->status] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.exam.fields.plan') }}
                                    </th>
                                    <td>
                                        @foreach($exam->plans as $key => $plan)
                                            <span class="label label-info">{{ $plan->title }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-primary" href="{{ route('frontend.take-exam', ['private' => 1, 'exam_id' => $exam->id]) }}" target="_blank">
                                Take Exam
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection