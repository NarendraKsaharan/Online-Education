@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.exam.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.exams.index') }}">
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
                <a class="btn btn-default" href="{{ route('admin.exams.index') }}">
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
            <a class="nav-link" href="#exam_questions" role="tab" data-toggle="tab">
                {{ trans('cruds.question.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="exam_questions">
            @includeIf('admin.exams.relationships.examQuestions', ['questions' => $exam->examQuestions])
        </div>
    </div>
</div>

@endsection