<div class="m-3">

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.feeRecord.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-courseFeeRecords">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.feeRecord.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.feeRecord.fields.course') }}
                            </th>
                            <th>
                                {{ trans('cruds.feeRecord.fields.student') }}
                            </th>
                            <th>
                                {{ trans('cruds.feeRecord.fields.fee') }}
                            </th>
                            <th>
                                {{ trans('cruds.feeRecord.fields.balance') }}
                            </th>
                            <th>
                                {{ trans('cruds.feeRecord.fields.join_date') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($feeRecords as $key => $feeRecord)
                            <tr data-entry-id="{{ $feeRecord->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $feeRecord->id ?? '' }}
                                </td>
                                <td>
                                    @foreach($feeRecord->courses as $key => $item)
                                        <span class="badge badge-info">{{ $item->title }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($feeRecord->students as $key => $item)
                                        <span class="badge badge-info">{{ $item->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    {{ $feeRecord->fee ?? '' }}
                                </td>
                                <td>
                                    {{ $feeRecord->balance ?? '' }}
                                </td>
                                <td>
                                    {{ $feeRecord->join_date ?? '' }}
                                </td>
                                <td>
                                    @can('fee_record_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.fee-records.show', $feeRecord->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
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
  
  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 10,
  });
  let table = $('.datatable-courseFeeRecords:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection