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
                <div class="table-responsive col-md-12">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-Filter">
                        <thead>
                            <tr>
                                <th width="10">
                                    
                                </th>
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
                                <th>
                                    {{-- ACTION --}}
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tablecontents">
                            @foreach ($schedules as $index => $schedule)
                            <input type="text" name="date" id="date{{$index}}" value="{{$schedule->schedule_due}}" hidden>
                            <tr class="row1"  data-id="{{ $schedule->position }}">
                        {{-- <tbody> --}}
                            {{-- <tr> --}}
                                <td>
                                    
                                </td>
                                <td>
                                    {{$schedule->id}}
                                </td>
                                <td>
                                    {{$schedule->schedule_due}}
                                </td>
                                <td>
                                    {{$schedule->file->fileId}}
                                </td>
                                <td>
                                    {{$schedule->file->title_of_content}}
                                </td>
                                <td>
                                    {{$schedule->file->duration}}
                                </td>
                                <td>
                                    {{$schedule->remark}}
                                </td>
                                <td>
                                    {{$schedule->position}}
                                </td>
                                <td>
                                    <button class="btn btn-xs btn-success">View</button>
                                    <button class="btn btn-xs btn-primary" onclick="editModal({{$schedule->id}})">Edit</button>
                                    <button class="btn btn-xs btn-danger">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="editForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="due" class="required">Schedule Due</label>
                            <input type="text" name="due" id="due" class="form-control form-control-sm date" />
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="file_id" class="required">File</label>
                            <div class="input-group">
                                <select name="file_id" id="file_id" class="form-control form-control-sm select2"  style="width: 100%;">
                                    <option value="">--- Select File ---</option>
                                    @foreach ($files as $file)
                                        <option value="{{$file->id}}">{{ $file->fileId}}-{{ $file->title_of_content}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="position">Position</label>
                            <input type="text" name="position" id="position" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
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
              columns: ':visible'
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

  </script>
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
        order: [[ 7, 'asc' ]],
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
<script>
    function editModal(id)
    {
        $('#editModal').modal('toggle');

        $.get('../../../admin/schedules/'+id+'/edit', function(response){
            $('#due').val(response.schedule_due);
            $('#file_id').val(response.file_id).change();
            $('#position').val(response.position);
        })

        $('#editForm').submit(function(e){
            e.preventDefault();

            let due = $('#due').val();
            let file_id = $('#file_id').val();
            let position = $('#position').val();
            let _token = $('input[name="_token"]').val();
            
            $.ajax({
                type: "PUT",
                url: '../../../admin/schedules/'+id,
                data: {
                    schedule_due: due,
                    file_id: file_id,
                    position: position,
                    _token: _token
                },
                success: function (response) {
                    if(response){
                        location.reload();
                    }
                }
            });
        })
    }
</script>
<script>
    $(function (){
        $( "#tablecontents" ).sortable({
          items: "tr",
          cursor: 'move',
          opacity: 0.6,
          update: function() {
              sendOrderToServer();
          }
        });

        function sendOrderToServer() {
          var order = [];
          var date = $('#date0').val();
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
            url: "{{ route('admin.schedules.reorder') }}",
                data: {
                order: order,
                date: date,
                _token: token
            },
            success: function(response) {
                if (response) {
                  location.reload();
                } else {
                  console.log(response);
                }
            }
          });
        }
    })
</script>
@endsection