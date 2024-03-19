<div class="m-3">
    @can('student_education_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.student-educations.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.studentEducation.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.studentEducation.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-studentStudentEducations">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.studentEducation.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.studentEducation.fields.student') }}
                            </th>
                            <th>
                                {{ trans('cruds.studentEducation.fields.class') }}
                            </th>
                            <th>
                                {{ trans('cruds.studentEducation.fields.passing_year') }}
                            </th>
                            <th>
                                {{ trans('cruds.studentEducation.fields.percentage') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($studentEducations as $key => $studentEducation)
                            <tr data-entry-id="{{ $studentEducation->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $studentEducation->id ?? '' }}
                                </td>
                                <td>
                                    {{ $studentEducation->student->name ?? '' }}
                                </td>
                                <td>
                                    {{ $studentEducation->class ?? '' }}
                                </td>
                                <td>
                                    {{ $studentEducation->passing_year ?? '' }}
                                </td>
                                <td>
                                    {{ $studentEducation->percentage ?? '' }}
                                </td>
                                <td>
                                    @can('student_education_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.student-educations.show', $studentEducation->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('student_education_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.student-educations.edit', $studentEducation->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('student_education_delete')
                                        <form action="{{ route('admin.student-educations.destroy', $studentEducation->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('student_education_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.student-educations.massDestroy') }}",
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
  let table = $('.datatable-studentStudentEducations:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection