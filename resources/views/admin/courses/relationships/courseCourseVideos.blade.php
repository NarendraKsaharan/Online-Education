<div class="m-3">
    @can('course_video_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.course-videos.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.courseVideo.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.courseVideo.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-courseCourseVideos">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.courseVideo.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.courseVideo.fields.course') }}
                            </th>
                            <th>
                                {{ trans('cruds.courseVideo.fields.topic') }}
                            </th>
                            <th>
                                {{ trans('cruds.courseVideo.fields.video_title') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courseVideos as $key => $courseVideo)
                            <tr data-entry-id="{{ $courseVideo->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $courseVideo->id ?? '' }}
                                </td>
                                <td>
                                    {{ $courseVideo->course->title ?? '' }}
                                </td>
                                <td>
                                    {{ $courseVideo->topic->title ?? '' }}
                                </td>
                                <td>
                                    {{ $courseVideo->video_title ?? '' }}
                                </td>
                                <td>
                                    @can('course_video_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.course-videos.show', $courseVideo->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('course_video_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.course-videos.edit', $courseVideo->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('course_video_delete')
                                        <form action="{{ route('admin.course-videos.destroy', $courseVideo->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('course_video_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.course-videos.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 10,
  });
  let table = $('.datatable-courseCourseVideos:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection