@extends('layouts.admin')
@section('content')

@can('file_create')
    @include('admin.files.create')
@endcan

<div class="card">
    <div class="card-header">
        Library File ID
    </div>

    <div class="card-body">
        <div class="table-responsive">
            
        </div>
    </div>
</div>

@endsection