@extends('layouts.admin')
@section('styles')
<style>
.btn-mini{
    border-radius: 50%;
    width: 1rem;
    height: 1rem;
}
body{
    overflow-y: scroll;
}
</style>
@endsection

@section('content')
@can('file_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('admin.files.create') }}">
            {{ trans('global.add') }} {{ trans('cruds.file.title_singular') }}
        </a>
    </div>
</div>
@endcan
<div class="card">
    <div class="card-header">
        Library File ID
    </div>

    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover ajaxTable datatable datatable-File">
                <thead>
                    <tr>
                        <th width="10">
                           {{-- &nbsp; --}}
                           #
                        </th>
                        <th width="30">
                            {{ trans('cruds.file.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.content_id') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.title_of_content') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.channel') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.segment') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.episode') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.duration') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.resolution') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.file_size') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.path') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.storage') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.date_received') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.air_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.year') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.period_of_time') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.genres') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.me') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.khmer_dub') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.poster') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.trailer_promo') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.synopsis') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.start_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.end_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.type') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.territory') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.remark') }}
                        </th>
                        <th>
                            {{ trans('cruds.file.fields.user') }}
                        </th>
                        <th>
                            Actions
                            {{-- &nbsp; --}}
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
@can('table_button')  
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
        }, {
            targets: [0, 1, 2, 3, 4, 26, 28],
            visible: true,
            }, { 
            targets: '_all', 
            visible: false 
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
              columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26]
            }
          },
          {
            extend: 'csv',
            className: 'btn-default',
            text: csvButtonTrans,
            exportOptions: {
              columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26]
            }
          },
          {
            extend: 'excel',
            className: 'btn-default',
            text: excelButtonTrans,
            exportOptions: {
              columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26]
            }
          },
          {
            extend: 'pdf',
            className: 'btn-default',
            text: pdfButtonTrans,
            exportOptions: {
            //   columns: ':visible'
              columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26]
            }
          },
          {
            extend: 'print',
            className: 'btn-default',
            text: printButtonTrans,
            exportOptions: {
              columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26]
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
@endcan

@can('table_nobutton')  
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
        }, {
            targets: [0, 1, 2, 3, 25, 26, 27, 28],
            visible: true,
            }, { 
            targets: '_all', 
            visible: false 
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
@endcan

<script>
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        @can('file_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.files.massDestroy') }}",
            className: 'btn-danger',
            action: function (e, dt, node, config) {
            var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                return entry.id
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

        // $.extend(true, $.fn.dataTable.defaults, {
        //     orderCellsTop: true,
        //     order: [[ 1, 'desc' ]],
        //     pageLength: 50,
        // });
        // let table = $('.datatable-File:not(.ajaxTable)').DataTable({ buttons: dtButtons })
        // $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
        //     $($.fn.dataTable.tables(true)).DataTable()
        //         .columns.adjust();
        // });

        let dtOverrideGlobals = {
            buttons: dtButtons,
            processing: true,
            serverSide: true,
            retrieve: true,
            aaSorting: [],
            ajax: "{{ route('admin.files.index') }}",
            columns: [
                { data: 'placeholder', name: 'placeholder' },
                { data: 'id', name: 'id' },
                { data: 'fileId', name: 'fileId' },
                { data: 'title_of_content', name: 'title_of_content' },
                { data: 'channels', name: 'channels' },
                { data: 'segment', name: 'segment' },
                { data: 'episode', name: 'episode' },
                { data: 'duration', name: 'duration' },
                { data: 'resolution', name: 'resolution' },
                { data: 'file_size', name: 'file_size' },
                { data: 'path', name: 'path' },
                { data: 'storage', name: 'storage' },
                { data: 'date_received', name: 'date_received' },
                { data: 'air_date', name: 'air_date' },
                { data: 'year', name: 'year' },
                { data: 'period', name: 'period' },
                { data: 'genres', name: 'genres' },
                { data: 'me', name: 'me' },
                { data: 'khmer_dub', name: 'khmer_dub' },
                { data: 'poster', name: 'poster' },
                { data: 'trailer_promo', name: 'trailer_promo' },
                { data: 'synopsis', name: 'synopsis' },
                { data: 'start_date', name: 'start_date' },
                { data: 'end_date', name: 'end_date' },
                { data: 'types', name: 'types' },
                { data: 'territory', name: 'territory' },
                { data: 'remark', name: 'remark' },
                { data: 'user', name: 'user' },
                { data: 'actions', name: '{{ trans('global.actions') }}' }
            ],
            orderCellsTop: true,
            order: [[ 1, 'desc' ]],
            pageLength: 50,
        };
        let table = $('.datatable-File').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    
    })
</script>
@endsection