@extends('layouts.admin')
@section('content')
<div class="form-group">
    <label>Date range button:</label>

    <form id="frm">
        <div class="input-group">
            <input type="button" class="form-control float-right" id="daterange-btn"/>
                <i class="far fa-calendar-alt"></i> Date range picker
                <i class="fas fa-caret-down"></i>
            
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#frm').submit(function(e) {
            e.preventDefault();
            let value = $('#daterange-btn').val();

            console.log(value);
        })
    })
</script>
@endsection
