@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.page.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.pages.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.page.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $page->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.page.fields.parent_page') }}
                                    </th>
                                    <td>
                                        {{ $page->parent_page->title ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.page.fields.title') }}
                                    </th>
                                    <td>
                                        {{ $page->title }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.page.fields.heading') }}
                                    </th>
                                    <td>
                                        {{ $page->heading }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.page.fields.show_in_menu') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Page::SHOW_IN_MENU_SELECT[$page->show_in_menu] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.page.fields.show_in_footer') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Page::SHOW_IN_FOOTER_SELECT[$page->show_in_footer] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.page.fields.status') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Page::STATUS_SELECT[$page->status] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.page.fields.description') }}
                                    </th>
                                    <td>
                                        {!! $page->description !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.page.fields.page_image') }}
                                    </th>
                                    <td>
                                        @foreach($page->page_image as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                                <img src="{{ $media->getUrl('thumb') }}">
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.page.fields.slug') }}
                                    </th>
                                    <td>
                                        {{ $page->slug }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.page.fields.meta_tag') }}
                                    </th>
                                    <td>
                                        {{ $page->meta_tag }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.page.fields.meta_title') }}
                                    </th>
                                    <td>
                                        {{ $page->meta_title }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.page.fields.meta_description') }}
                                    </th>
                                    <td>
                                        {{ $page->meta_description }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.pages.index') }}">
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