@extends('layouts.admin')
@section('content')
<h4 class="mb-4">Schedule Builder</h4>
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
    </div>
    <div class="card-body row">
        <div class="col-md-12">
            <table class=" table table-bordered table-striped table-hover datatable datatable-List">
                <thead>
                    <tr>
                        <th width="30">
                            ID
                        </th>
                        <th>
                            SCHEDULE DUE
                        </th>
                        <th>
                            TOTAL FILE
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody">
                    @foreach ($days as $day)
                        <tr  class="row1" data-id="{{ $day->id }}">
                            <td>{{$day->id}}</td>
                            <td>{{$day->schedule_on}}</td>
                            <td>{{$day->files->count()}}</td>
                            <td>
                                @can('file_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.files.edit', $day->id) }}">
                                        {{ trans('global.edit') }}
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
{{-- @include('partials.script') --}}
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-List:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection