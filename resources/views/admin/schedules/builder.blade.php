@extends('layouts.admin')
@section('content')
<h4>Schedule Builder</h4>
<div class="card">
    <div class="card-body row">
        <div class="col-md-5 mb-3">
            <form action="{{route('admin.schedules.getBuilder')}}" method="GET">
                @csrf  
                <div class="form-group">
                    <label for="schedule_on">Schedule On</label>
                    <input type="text" name="schedule_on" id="schedule_on" class="form-control form-control-sm col-md-4 dateYMD">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-secondary">Filter</button>
                    <button type="button" onclick="$(document).ready(function(){location.reload();})" class="btn btn-sm btn-danger">Reload</button>
                </div>
            </form>    
        </div>    
        <div class="col-md-12">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Schedule">
                <thead>
                    <tr>
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
                            SCHEDULE DUE
                        </th>
                        <th>
                            POSITION ORDER
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody id="tablecontents" data-id="{{$schedule->id}}">
                    @foreach ($files as $file)
                        <tr  class="row1" data-id="{{ $file->id }}">
                            <td>{{$file->id}}</td>
                            <td>{{$file->fileId}}</td>
                            <td>{{$file->title_of_content}}</td>
                            <td>{{$file->duration}}</td>
                            <td>{{$file->air_date}}</td>
                            <td>{{$schedule->schedule_on}}</td>
                            <td>{{$file->pivot->position_order}}</td>
                            <td>
                                @can('file_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.files.edit', $file->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                                @can('file_edit')
                                    <a class="btn btn-xs btn-danger" href="{{ route('admin.files.edit', $file->id) }}">
                                        {{ trans('global.delete') }}
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
@endsection
@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
{{-- <script>
    $(function() {
      let copyButtonTrans = '{{ trans('global.datatables.copy') }}'
      let csvButtonTrans = '{{ trans('global.datatables.csv') }}'
      let excelButtonTrans = '{{ trans('global.datatables.excel') }}'
      let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}'
      let printButtonTrans = '{{ trans('global.datatables.print') }}'
      let colvisButtonTrans = '{{ trans('global.datatables.colvis') }}'
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
          {
            extend: 'copy',
            className: 'btn-default',
            text: copyButtonTrans,
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'csv',
            className: 'btn-default',
            text: csvButtonTrans,
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'excel',
            className: 'btn-default',
            text: excelButtonTrans,
            exportOptions: {
              columns: [2, 3, 4, 5, 6]
            }
          },
          {
            extend: 'pdf',
            className: 'btn-default',
            text: pdfButtonTrans,
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'print',
            className: 'btn-default',
            text: printButtonTrans,
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'colvis',
            className: 'btn-default',
            text: colvisButtonTrans,
            exportOptions: {
              columns: ':visible'
            }
          }
        ]
      });

      $.fn.dataTable.ext.classes.sPageButton = '';
    });

</script> --}}
<script type="text/javascript">
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[ 6, 'desc' ]],
            pageLength: 100,
        });
        let table = $('.datatable-Schedule:not(.ajaxTable)').DataTable({ buttons: dtButtons })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    //   $(".datatable-Schedule").DataTable();

        $( "#tablecontents" ).sortable({
            items: "tr",
            cursor: 'move',
            opacity: 0.6,
            update: function() {
                sendOrderToServer();
            }
        });

        function sendOrderToServer() {
            var day = $('#tablecontents').attr('data-id');
            var order = [];
            var token = $('meta[name="csrf-token"]').attr('content');
            $('tr.row1').each(function(index,element) {
            order.push({
                id: $(this).attr('data-id'),
                position: index+1
            });
            });

            $.ajax({
                type: "POST", 
                dataType: "json", 
                url: "{{route('admin.schedules.reorder') }}",
                data: {
                    day: day,
                    order: order,
                    _token: token
                },
                success: function(response) {
                    if (response.status == "success") {
                        console.log(response);
                    } else {
                        console.log(response);
                    }
                },
                error: function(response) {
                    if (response.status == "success") {
                        console.log(response);
                    } else {
                        console.log(response);
                    }
                }
            })
        }
    });
  </script>
<script>
    $(document).ready(function () {
        $('#frm_filter').submit(function(e) {
            e.preventDefault();
            
            let day     = $('#day_id').val();
            let date    = $('#schedule_on').val();
            let _token  = $('input[name="_token"]').val();

            $.ajax({
                type: "POST",
                url: "{{route('admin.schedules.getBuilder')}}",
                data: {
                    _token: _token,
                    id: day,
                    date: date,
                },
                success: function (response) {
                    console.log(response)

                },
                error: function (response) {
                    console.log(response)
                }
            });
        })
    })
</script>
@endsection