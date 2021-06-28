@extends('layouts.admin')
@section('content')
<h4>Schedule Builder</h4>
    <div class="card">
        <div class="card-body">
            <form action="{{route('admin.schedules.builder.sort')}}" method="GET">
                <div class="form-group col-md-5">
                    <label for="schedule_due">Schedule Due</label>
                    <input type="text" name="schedule_due" id="schedule_due" class="form-control dateYMD">
                </div>
                <div class="form-group col-md-3">
                    <button type="submit" class="btn btn-sm btn-danger">Filter</button>
                </div>
            </form>

            <div class="mt-4 row">
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-Filter">
                        <thead>
                            <tr>
                                <th width="30">
                                    ID
                                </th>
                                <th>
                                    SCHEDULE DUE
                                </th>
                                <th>
                                    FILE ID
                                </th>
                                <th>
                                    TITLE
                                </th>
                                <th>
                                    DURATION
                                </th>
                                <th>
                                    REMARK
                                </th>
                                <th>
                                    POSITION
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@parent
@include('partials.script')
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('category_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.categories.massDestroy') }}",
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
    order: [[ 3, 'asc' ]],
    pageLength: 100,
  });
  $('.datatable-Filter:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
    $('button[data-toggle^="sidebar-"]').click(function () {
        setTimeout(function() {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        }, 275);
    })
})
</script>
@endsection