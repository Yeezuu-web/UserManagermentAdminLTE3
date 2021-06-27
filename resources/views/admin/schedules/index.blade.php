@extends('layouts.admin')
@section('content')
@can('schedule_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <button class="btn btn-success" onclick="create()">
                Add Schedules
            </button>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-body row">
        <div class="col-md-12">
            <table class="table table-bordered table-striped table-hover ajaxTable datatable datatable-Schedule">
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
                            ACTION
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="createForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add File to Schedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="schedule_due" class="required">Schedule Due</label>
                            <input type="text" name="schedule_due" id="schedule_due" class="form-control form-control-sm date" />
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
                            <label for="remark">Remark</label>
                            <input type="text" name="remark" id="remark" class="form-control" />
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
@include('partials.script')
<script>
    $(function () {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
    @can('schedule_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.schedules.massDestroy') }}",
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
            { data: 'schedule_due', name: 'schedule_due' },
            { data: 'fileId', name: 'fileId' },
            { data: 'title', name: 'title' },
            { data: 'duration', name: 'duration' },
            { data: 'remark', name: 'remark' },
            { data: 'position', name: 'position' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
        orderCellsTop: true,
        order: [[ 1, 'desc' ]],
        pageLength: 100,
    };
    let table = $('.datatable-Schedule').DataTable(dtOverrideGlobals);
    $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
    
});
</script>
<script>
    function create(){
        $('#createModal').modal('toggle');

        $('#createForm').submit(function(e) {
            e.preventDefault();

            let schedule_due = $('#schedule_due').val();
            let file_id = $('#file_id').val();
            let remark = $('#remark').val();
            let _token = $('input[name="_token"]').val();

            $.ajax({
                type: "POST",
                url: "{{route('admin.schedules.store')}}",
                data: {
                    schedule_due: schedule_due,
                    file_id: file_id,
                    remark: remark,
                    _token: _token
                },
                success: function (response) {
                    console.log(response);
                }
            });
            
        })

    }
</script>
@endsection