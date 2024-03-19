@extends('layouts.frontend')
@section('content')

<div class="mx-5">
    <div class="mx-4">
        <div class="card mx-5">
            <div class="card-header">
                Fee List
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover datatable datatable-FeeRecord">
                        <thead>
                            <tr>
                                <th width="10">

                                </th>
                                <th>
                                    {{ trans('cruds.fee.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.fee.fields.course') }}
                                </th>
                                <th>
                                    {{ trans('cruds.fee.fields.student') }}
                                </th>
                                <th>
                                    Fee
                                </th>
                                <th>
                                    Balance
                                </th>
                                <th>
                                    Join Date
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                            <tr>
                                <td>
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <select class="search">
                                        <option value>{{ trans('global.all') }}</option>
                                            <option value=""></option>
                                    </select>
                                </td>
                                <td>
                                    <select class="search">
                                        <option value>{{ trans('global.all') }}</option>
                                            <option value=""></option>
                                    </select>
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                    <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
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
                                        {{ $feeRecord->course->title ?? '' }}
                                    </td>
                                    <td>
                                        {{ $feeRecord->student->name }}
                                    </td>
                                    <td>
                                        {{ $feeRecord->amount ?? '' }}
                                    </td>
                                    <td>
                                        {{ $feeRecord->payment_date ?? '' }}
                                    </td>
                                    <td>
                                        @can('fee_record_show')
                                            <a class="btn btn-xs btn-primary" href="{{ route('frontend.fees.show', $feeRecord->student->id) }}">
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
</div>



@endsection
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
  let table = $('.datatable-FeeRecord:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
let visibleColumnsIndexes = null;
$('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value

      let index = $(this).parent().index()
      if (visibleColumnsIndexes !== null) {
        index = visibleColumnsIndexes[index]
      }

      table
        .column(index)
        .search(value, strict)
        .draw()
  });
table.on('column-visibility.dt', function(e, settings, column, state) {
      visibleColumnsIndexes = []
      table.columns(":visible").every(function(colIdx) {
          visibleColumnsIndexes.push(colIdx);
      });
  })
})

</script>
@endsection