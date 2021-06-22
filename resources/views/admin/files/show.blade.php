@extends('layouts.admin')

@section('content')
    {{$file->fileId ?? ''}}
    {{$channel}} <br>
    {{$type}} <br>
    {{$genre}}
@endsection