@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.file.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.files.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.id') }}
                        </th>
                        <td>
                            {{ $file->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.content_id') }}
                        </th>
                        <td>
                            {{ $file->content_id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.title_of_content') }}
                        </th>
                        <td>
                            {{ $file->title_of_content }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.channel') }}
                        </th>
                        <td>
                            {{ $channel }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.segment') }}
                        </th>
                        <td>
                            {{ $file->segment }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.episode') }}
                        </th>
                        <td>
                            {{ $file->episode }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.file_extension') }}
                        </th>
                        <td>
                            {{ $file->file_extension }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.duration') }}
                        </th>
                        <td>
                            {{ $file->duration }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.resolution') }}
                        </th>
                        <td>
                            {{ $file->resolution }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.file_size') }}
                        </th>
                        <td>
                            {{ $file->file_size }} {{ $file->size_type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.path') }}
                        </th>
                        <td>
                            {{ $file->path }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.storage') }}
                        </th>
                        <td>
                            {{ $file->storage }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.date_received') }}
                        </th>
                        <td>
                            {{ $file->date_received }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.air_date') }}
                        </th>
                        <td>
                            {{ $file->air_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.year') }}
                        </th>
                        <td>
                            {{ $file->year }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.period_of_time') }}
                        </th>
                        <td>
                            {{ $file->period }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.start_date') }}
                        </th>
                        <td>
                            {{ $file->start_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.end_date') }}
                        </th>
                        <td>
                            {{ $file->end_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.type') }}
                        </th>
                        <td>
                            {{ $type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.territory') }}
                        </th>
                        <td>
                            {{ $file->territory }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.genres') }}
                        </th>
                        <td>
                            {{ $genre }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.me') }}
                        </th>
                        <td>
                            @if ( $file->me == '1')
                            <span class="badge badge-success">
                                Have
                            </span>
                            @else
                            <span class="badge badge-danger">
                                Don't Have
                            </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.khmer_dub') }}
                        </th>
                        <td>
                                @if( $file->khmer_dub == '1')
                                <span class="badge badge-success">
                                    Have
                                </span>
                                @else 
                                <span class="badge badge-danger">
                                    Don't Have
                                </span>
                                @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.poster') }}
                        </th>
                        <td>
                                @if( $file->poster == '1')
                                <span class="badge badge-primary">
                                    Have
                                </span>
                                @else
                                <span class="badge badge-danger">
                                    Don't Have
                                </span>
                                @endif
                        
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.trailer_promo') }}
                        </th>
                        <td>
                                @if( $file->trailer_promo == '1')
                                <span class="badge badge-success">
                                    Have
                                </span>
                                @else
                                <span class="badge badge-danger">
                                    Don't Have
                                </span>
                                @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.synopsis') }}
                        </th>
                        <td>
                            {{ $file->synopsis }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.remark') }}
                        </th>
                        <td>
                            {{ $file->remark }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.file.fields.file_available') }}
                        </th>
                        <td>
                            <span class="badge badge-info">
                                @if( $file->file_available == '1')
                                Available
                                @else
                                Unavailable
                                @endif
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.files.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
