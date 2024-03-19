@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.question.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.questions.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.question.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $question->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.question.fields.course') }}
                                    </th>
                                    <td>
                                        {{ $question->course->title ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.question.fields.exam') }}
                                    </th>
                                    <td>
                                        {{ $question->exam->title ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.question.fields.status') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Question::STATUS_SELECT[$question->status] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.question.fields.type') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Question::TYPE_SELECT[$question->type] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.question.fields.question') }}
                                    </th>
                                    <td>
                                        {{ $question->question }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.question.fields.image') }}
                                    </th>
                                    <td>
                                        @foreach($question->image as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                                <img src="{{ $media->getUrl('thumb') }}">
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.question.fields.answer') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Question::ANSWER_SELECT[$question->answer] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.question.fields.answer_image') }}
                                    </th>
                                    <td>
                                        @foreach($question->answer_image as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                                <img src="{{ $media->getUrl('thumb') }}">
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.questions.index') }}">
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