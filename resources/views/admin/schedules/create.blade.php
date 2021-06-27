@extends('layouts.admin')
@section('content')
<h4>Create Schedule</h4>
<div class="card">
    <div class="card-body">
        <form action="">
            @csrf
            <div class="form-group">
                <label for="schedule_due" class="required">Scheduel Due</label>
                <input type="text" name="schedule_due" id="schedule_due" class="form-control form-control-sm date">
                <span class="invalid-feedback"></span>
            </div>
            <div class="card">
                <div class="card-header">
                    Products
                </div>
        
                <div class="card-body">
                    <table class="table" id="products_table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="product0">
                                <td>
                                    <select name="products[]" class="form-control select2" id="td1">
                                        <option value="">-- choose product --</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">
                                                {{ $product->fileId }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="quantities[]" class="form-control" value="1" />
                                </td>
                            </tr>
                            <tr id="product1"></tr>
                        </tbody>
                    </table>
        
                    <div class="row">
                        <div class="col-md-12">
                            <button id="add_row" class="btn btn-default pull-left">+ Add Row</button>
                            <button id='delete_row' class="pull-right btn btn-danger">- Delete Row</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-sm btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>



@endsection
@section('scripts')
<script>
      $(document).ready(function(){
    let row_number = 1;
    $("#add_row").click(function(e){
      e.preventDefault();
      let new_row_number = row_number - 1;
      $('#product' + row_number).html($('#product' + new_row_number).html()).find('td:first-child');
      $('#product' + row_number).append('<select id="td' + (row_number + 1) + '"></select>');
      $('#products_table').append('<tr id="product' + (row_number + 1) + '"></tr>');
      row_number++;
    });

    $("#delete_row").click(function(e){
      e.preventDefault();
      if(row_number > 1){
        $("#product" + (row_number - 1)).html('');
        row_number--;
      }
    });
  });
</script>
@endsection