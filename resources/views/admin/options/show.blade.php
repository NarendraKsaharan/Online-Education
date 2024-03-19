@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.option.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.options.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.option.fields.id') }}
                        </th>
                        <td>
                            {{ $option->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.option.fields.question') }}
                        </th>
                        <td>
                            {{ $option->question->question ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.option.fields.option_sequence') }}
                        </th>
                        <td>
                            {{ App\Models\Option::OPTION_SEQUENCE_SELECT[$option->option_sequence] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.option.fields.option_value') }}
                        </th>
                        <td>
                            {{ $option->option_value }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.option.fields.option_image') }}
                        </th>
                        <td>
                            @foreach($option->option_image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.options.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection