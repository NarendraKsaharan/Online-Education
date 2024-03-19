@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.course.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.courses.index') }}">
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
                <a class="btn btn-default" href="{{ route('admin.courses.index') }}">
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
            <a class="nav-link" href="#course_course_videos" role="tab" data-toggle="tab">
                {{ trans('cruds.courseVideo.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#course_assignments" role="tab" data-toggle="tab">
                {{ trans('cruds.assignment.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#course_assign_assignments" role="tab" data-toggle="tab">
                {{ trans('cruds.assignAssignment.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#course_plans" role="tab" data-toggle="tab">
                {{ trans('cruds.plan.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#course_topics" role="tab" data-toggle="tab">
                {{ trans('cruds.topic.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#course_exams" role="tab" data-toggle="tab">
                {{ trans('cruds.exam.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#course_questions" role="tab" data-toggle="tab">
                {{ trans('cruds.question.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#course_fees" role="tab" data-toggle="tab">
                {{ trans('cruds.fee.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#course_students" role="tab" data-toggle="tab">
                {{ trans('cruds.student.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#course_fee_records" role="tab" data-toggle="tab">
                {{ trans('cruds.feeRecord.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="course_course_videos">
            @includeIf('admin.courses.relationships.courseCourseVideos', ['courseVideos' => $course->courseCourseVideos])
        </div>
        <div class="tab-pane" role="tabpanel" id="course_assignments">
            @includeIf('admin.courses.relationships.courseAssignments', ['assignments' => $course->courseAssignments])
        </div>
        <div class="tab-pane" role="tabpanel" id="course_assign_assignments">
            @includeIf('admin.courses.relationships.courseAssignAssignments', ['assignAssignments' => $course->courseAssignAssignments])
        </div>
        <div class="tab-pane" role="tabpanel" id="course_plans">
            @includeIf('admin.courses.relationships.coursePlans', ['plans' => $course->coursePlans])
        </div>
        <div class="tab-pane" role="tabpanel" id="course_topics">
            @includeIf('admin.courses.relationships.courseTopics', ['topics' => $course->courseTopics])
        </div>
        <div class="tab-pane" role="tabpanel" id="course_exams">
            @includeIf('admin.courses.relationships.courseExams', ['exams' => $course->courseExams])
        </div>
        <div class="tab-pane" role="tabpanel" id="course_questions">
            @includeIf('admin.courses.relationships.courseQuestions', ['questions' => $course->courseQuestions])
        </div>
        <div class="tab-pane" role="tabpanel" id="course_fees">
            @includeIf('admin.courses.relationships.courseFees', ['fees' => $course->courseFees])
        </div>
        <div class="tab-pane" role="tabpanel" id="course_students">
            @includeIf('admin.courses.relationships.courseStudents', ['students' => $course->courseStudents])
        </div>
        <div class="tab-pane" role="tabpanel" id="course_fee_records">
            @includeIf('admin.courses.relationships.courseFeeRecords', ['feeRecords' => $course->courseFeeRecords])
        </div>
    </div>
</div>

@endsection