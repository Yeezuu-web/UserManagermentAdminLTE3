@extends('layouts.admin')
@section('content')
@can('user_alert_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.schedules.list') }}">
                View Schedules List
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-body row">
        <div class="col-md-12">
            <h4>Make Schedule</h4>
            <label for="schedule_on">Schedule On</label>
            <input type="text" name="schedule_on" id="schedule_on" class="form-control form-control-sm col-md-4 dateYMD mb-4">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-File">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th width="30">
                            ID
                        </th>
                        <th>
                            File ID
                        </th>
                        <th>
                            TITLE
                        </th>
                        <th>
                            DURATION
                        </th>
                        <th>
                            AIR DATE
                        </th>
                        <th>
                            ACTION
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script>
    $(function() {
      let selectAllButtonTrans = '{{ trans('global.select_all') }}'
      let selectNoneButtonTrans = '{{ trans('global.deselect_all') }}'

      let languages = {
        'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
      };

      $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
      $.extend(true, $.fn.dataTable.defaults, {
        language: {
          url: languages['{{ app()->getLocale() }}']
        },
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0
        }, {
            orderable: false,
            searchable: false,
            targets: -1
        }],
        select: {
          style:    'multi+shift',
          selector: 'td:first-child'
        },
        order: [],
        scrollX: true,
        pageLength: 100,
        dom: 'lBfrtip<"actions">',
        buttons: [
          {
            extend: 'selectAll',
            className: 'btn-primary',
            text: selectAllButtonTrans,
            exportOptions: {
              columns: ':visible'
            },
            action: function(e, dt) {
              e.preventDefault()
              dt.rows().deselect();
              dt.rows({ search: 'applied' }).select();
            }
          },
          {
            extend: 'selectNone',
            className: 'btn-primary',
            text: selectNoneButtonTrans,
            exportOptions: {
              columns: ':visible'
            }
          },    
        ]
      });

      $.fn.dataTable.ext.classes.sPageButton = '';
    });

</script>
<script>
    $(function () {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
    @can('schedule_access')
    let importButtonTrans = 'Bulk Import';
    let importButton = {
        text: importButtonTrans,
        url: "{{ route('admin.schedules.massImport') }}",
        className: 'btn-info',
        action: function (e, dt, node, config) {
        var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
            return entry.id
        });
        var schedule_on = $('#schedule_on').val();
        

        if (ids.length === 0) {
            Swal.fire(
                'Opss!',
                '{{ trans('global.datatables.zero_selected') }}',
                'error'
            )
            return
        }

        if (schedule_on === '') {
            Swal.fire(
                'Opss!',
                'The schedule on input cannot be empty.',
                'error'
            )
            return
        }

        if (confirm('{{ trans('global.areYouSure') }}')) {
            $.ajax({
            headers: {'x-csrf-token': _token},
            type: 'POST',
            url: config.url,
            data: { 
                ids: ids, 
                schedule_on: schedule_on, 
                _method: 'POST'
            },
            success: function (response){
                if(response === 'success'){
                    Swal.fire(
                        'Done!',
                        'File added to schedul.',
                        'success'
                    )
                    setTimeout(function () { location.reload() }, 1800)
                }
            },
            error: function (res) {
                console.log(res)
            }
            })
        }
        }
    }
    dtButtons.push(importButton)
    @endcan

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.schedules.index') }}",
    columns: [
        { data: 'placeholder', name: 'placeholder' },
        { data: 'id', name: 'id' },
        { data: 'fileId', name: 'fileId' },
        { data: 'title_of_content', name: 'title_of_content' },
        { data: 'duration', name: 'duration' },
        { data: 'air_date', name: 'air_date' },
        { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-File').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
    });
</script>
@endsection