@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.block.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.blocks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.block.fields.id') }}
                        </th>
                        <td>
                            {{ $block->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.block.fields.title') }}
                        </th>
                        <td>
                            {{ $block->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.block.fields.heading') }}
                        </th>
                        <td>
                            {{ $block->heading }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.block.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Block::STATUS_SELECT[$block->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.block.fields.description') }}
                        </th>
                        <td>
                            {!! $block->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.block.fields.slug') }}
                        </th>
                        <td>
                            {{ $block->slug }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.block.fields.block_image') }}
                        </th>
                        <td>
                            @foreach($block->block_image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.blocks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection