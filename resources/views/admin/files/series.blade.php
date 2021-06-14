@extends('layouts.admin')
@section('styles')
<style>
    .title{
        font-size: 1.8rem;
        font-weight: bold;
    }
</style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            Tpye and Series
        </div>
        <div class="card-body">
            @can('sereis_create')
            <form id="frm_series" autocomplete="off">
                @csrf
                <div class="form-group col-md-5">
                    <label for="name" class="required">Name</label>
                    <input type="text" name="name" id="name" class="form-control">
                    <span class="invalid-feedback" id="name_error"></span>
                </div>
                <div class="form-group col-md-1">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.create') }}
                    </button>
                </div>
            </form>
            @endcan
            <h3 class="title col-md-6 mt-5">Type & Series</h3>
            <table class="table table-bordered col-md-6">
                <thead>
                  <tr>
                    <th style="width: 10px">Series</th>
                    <th>Type</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($series as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>
                            @can('series_edit')
                                <button class="btn btn-xs btn-info" onclick="edit({{$item->id}})" data-toggle="modal" data-target="#editModal">Edit</button>
                            @endcan
                            @can('series_delete')
                                <button class="btn btn-xs btn-danger">Delete</button>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
        </div>
    </div>

    
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="edit_series" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="form-group col-md-5">
                        <label for="fid">ID</label>
                        <input type="text" name="fid" id="fid" value="{{$item->id}}" class="form-control" disabled>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="name" class="required">Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control">
                        <span class="invalid-feedback" id="edit_name_error"></span>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
          </div>
        </div>
      </div>
@endsection

@section('scripts')
@parent
<script>
    $('#frm_series').submit(function(e) {
        e.preventDefault();
        let name = $('#name').val();
        let _token = $('input[name="_token"]').val();

         
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        $.ajax({
            type: "POST",
            url: "{{ route('admin.files.series.store') }}",
            data: {
                name: name,
                _token: _token
            },
            success: function (response) {
                if(response){
                    Toast.fire({
                        icon: 'success',
                        title: 'Series create successfully'
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            },
            error: function (response) {
                $('#name_error').text(response.responseJSON.errors.name);
                if(response.responseJSON.errors.name){
                    $('#name').addClass('is-invalid');
                }
            }
        });
    })

    function edit(id)
    {
        $.get('series/'+ id +'/edit', function (series) {
            console.log(series);
            $('#fid').val(series.id);
            $('#edit_name').val(series.name);
        });

        $('#edit_series').submit(function(e) {
            e.preventDefault();
            let id = $('#fid').val();
            let name = $('#edit_name').val();
            let _token = $('input[name="_token"]').val();
    
             
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
    
            $.ajax({
                type: "POST",
                url: "series/update/"+id,
                data: {
                    id: id,
                    name: name,
                    _token: _token
                },
                success: function (response) {
                    if(response){
                        Toast.fire({
                            icon: 'success',
                            title: 'Series create successfully'
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    }
                },
                error: function (response) {
                    $('#edit_name_error').text(response.responseJSON.errors.name);
                    if(response.responseJSON.errors.name){
                        $('#edit_name').addClass('is-invalid');
                    }
                }
            });
        })
    }

</script>
@endsection