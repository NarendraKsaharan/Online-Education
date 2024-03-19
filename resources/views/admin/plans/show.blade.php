@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.plan.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.plans.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.plan.fields.id') }}
                        </th>
                        <td>
                            {{ $plan->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plan.fields.course') }}
                        </th>
                        <td>
                            {{ $plan->course->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plan.fields.title') }}
                        </th>
                        <td>
                            {{ $plan->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plan.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Plan::STATUS_SELECT[$plan->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plan.fields.price') }}
                        </th>
                        <td>
                            {{ $plan->price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plan.fields.special_price') }}
                        </th>
                        <td>
                            {{ $plan->special_price }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.plans.index') }}">
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
            <a class="nav-link" href="#plan_exams" role="tab" data-toggle="tab">
                {{ trans('cruds.exam.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="plan_exams">
            @includeIf('admin.plans.relationships.planExams', ['exams' => $plan->planExams])
        </div>
    </div>
</div>

@endsection