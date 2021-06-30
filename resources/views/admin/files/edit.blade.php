@extends('layouts.admin')

@section('content')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-secondary" href="{{ route('admin.files.index') }}">
            {{ trans('global.back') }}
        </a>
    </div>
</div>
<div class="card">
    <div class="card-header bg-gradient-info">
        <div class="float-left">
            {{ trans('global.create') }} {{ trans('cruds.file.title_singular') }}
        </div>
        <div class="float-right">
            <i class="fa fa-plus toggle-show-card" style="cursor:pointer;display:none;" onclick="showCard()" data-toggle="tooltip" data-placement="top" title="Extend"></i>
            <i class="fa fa-minus toggle-hide-card" style="cursor:pointer;" onclick="hideCard()" data-toggle="tooltip" data-placement="top" title="Minimize"></i>
        </div>
    </div>

    <div class="card-body" id="card-boay-section">
        <form method="POST" action="{{ route("admin.files.update", [$file->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
                <div class="form-group col-md-3">
                    <label class="required" for="series_id"
                        >{{ trans('cruds.file.fields.type_of_content') }}</label>
                    <select name="series_id" id="series_id" class="form-control form-control-sm">
                        <option value="">Please select</option>
                        @foreach ($series as $value => $key)
                            <option value="{{ $key }}" {{ old('series_id',  $file->series_id) === $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    <span class="invalid-feedback" id="type_of_content_error">
                    </span>
                </div>

                <div class="form-group col-md-3">
                    <label class="required" for="title_of_content"
                        >{{ trans('cruds.file.fields.title_of_content') }}</label>
                    <input type="text" name="title_of_content" id="title_of_content" class="form-control form-control-sm" value="{{ old('title_of_content', $file->title_of_content) }}" />
                    <span class="invalid-feedback" id="title_of_content_error">
                    </span>
                </div>

                <div class="form-group col-md-3">
                    <label class="required" for="channels">{{ trans('cruds.file.fields.channel') }}</label>
                    <div class="select2-purple">
                        <select class="form-control form-control-sm select2" name="channels[]" id="channels" multiple>
                            @foreach($channels as $id => $channel)
                                <option value="{{ $id }}" {{ (in_array($id, old('channels', [])) || $file->channels->contains($id)) ? 'selected' : '' }}>{{ $channel }}</option>
                            @endforeach
                        </select>
                        <span class="invalid-feedback" id="channels_error">
                        </span>
                    </div>
                </div>

                <div class="form-group col-md-3" id="segments">
                    <label for="segment">{{ trans('cruds.file.fields.segment') }}</label>
                    <input class="form-control form-control-sm" type="number" name="segment" id="segment" value="{{ old('segment', $file->segment) }}" min="0">
                    <span class="invalid-feedback" id="segment_error">
                    </span>
                </div>
                
            </div>

            <div class="dropdown-divider mt-4 mb-2"></div>

            <div class="row" style="position:realtive;">
                <i class="fa fa-plus ml-2 toggle-show" style="cursor:pointer;position:absolute;display:none;" onclick="show()" data-toggle="tooltip" data-placement="top" title="Extend"></i>
                <i class="fa fa-minus ml-2 toggle-hide" style="cursor:pointer;position:absolute;" onclick="hide()" data-toggle="tooltip" data-placement="top" title="Minimize"></i>
            </div>

            <div class="row mt-4" id="section">
                
                <div class="form-group col-md-3">
                    <label for="episode">{{ trans('cruds.file.fields.episode') }}</label>
                    <input type="number" name="episode" id="episode" class="form-control form-control-sm" value="{{ old('episode', $file->episode) }}" min="0"/>
                </div>

                <div class="form-group col-md-3">
                    <label for="file_extension">{{ trans('cruds.file.fields.file_extension') }}</label>
                    <select name="file_extension" id="file_extension" class="form-control form-control-sm">
                        <option value="">Please select</option>
                        @foreach(App\Models\File::FILE_EXTENSION_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('file_extension', $file->file_extension) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-3 ">
                    <label for="duration">{{ trans('cruds.file.fields.duration') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-clock"></i>
                        </span>
                        </div>
                        <input type="text" name="duration" id="duration" class="form-control form-control-sm timepicker" value="{{ old('duration', $file->duration) }}"/>
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="resolution">{{ trans('cruds.file.fields.resolution') }}</label>
                    <select name="resolution" id="resolution" class="form-control form-control-sm">
                        <option value="">Please select</option>
                        @foreach(App\Models\File::RESOLUTION_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('resolution', $file->resolution) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="file_size">{{ trans('cruds.file.fields.file_size') }}</label>
                    <div class="input-group">
                        <select class="form-control form-control-sm col-md-3" name="size_type" id="size_type">
                            <option value="">Select</option>
                            @foreach(App\Models\File::SIZE_TYPE_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('size_type', $file->size_type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <input type="number"name="file_size" id="file_size" class="form-control form-control-sm col-md-9" value="{{ old('file_size', $file->file_size) }}" min="0"/>
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="path">{{ trans('cruds.file.fields.path') }}</label>
                    <input type="text" name="path" id="path" class="form-control form-control-sm" value="{{ old('path', $file->path) }}"/>
                </div>

                <div class="form-group col-md-3">
                    <label for="storage">{{ trans('cruds.file.fields.storage') }}</label>
                    <select name="storage" id="storage" class="form-control form-control-sm">
                        <option value="">Please select</option>
                        @foreach(App\Models\File::STORAGE_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('storage', $file->storage) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="date_received">{{ trans('cruds.file.fields.date_received') }} (m-d-Y)</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                        </div>
                        <input type="text" name="date_received" id="date_received" class="form-control date form-control-sm" value="{{ old('date_received', $file->date_received) }}"/>
                    </div>
                </div>                

                <div class="form-group col-md-3">
                    <label for="date_received">{{ trans('cruds.file.fields.air_date') }} (m-d-Y)</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                        </div>
                        <input  type="text" name="air_date" id="air_date" class="form-control date form-control-sm" value="{{ old('air_date', $file->air_date) }}"/>
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="year">{{ trans('cruds.file.fields.year') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                        </div>
                        <input type="text" name="year" id="year" class="form-control form-control-sm yearpicker" value="{{ old('year', $file->year) }}"/>
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="period">{{ trans('cruds.file.fields.period_of_time') }}</label>

                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-clock"></i>
                        </span>
                        </div>
                        <input type="text" id="period" name="period" class="form-control form-control-sm float-right" value="{{ old('period', $file->period) }}"/>
                    </div>
                </div>

                <div class="form-group col-md-3 mb-4">
                    <label for="start_date">{{ trans('cruds.file.fields.start_date') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                        </div>
                        <input type="text" name="start_date" id="start_date" class="form-control form-control-sm date" value="{{ old('start_date', $file->start_date) }}"/>
                    </div>
                </div>

                <div class="form-group col-md-3 mb-4">
                    <label for="end_date">{{ trans('cruds.file.fields.end_date') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                        </div>
                        <input type="text" name="end_date" id="end_date" class="form-control form-control-sm date" value="{{ old('end_date', $file->end_date) }}"/>
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="types">{{ trans('cruds.file.fields.type') }}</label>
                    <div class="select2-purple">
                        <input type="text" class="form-control form-control-sm" name="types" id="types" value="" hidden/>
                        <select class="form-control form-control-sm select2" name="types[]" id="types" multiple>
                            @foreach(App\Models\File::TYPE_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ (in_array($key, old('types', [])) || in_array($key, $file->types ? old('types', $file->types) : old('types', []))) ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="territory">{{ trans('cruds.file.fields.territory') }}</label>
                    <select name="territory" id="territory" class="form-control form-control-sm">
                        <option value="">Please select</option>
                        @foreach(App\Models\File::TERRITORY_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('territory', $file->territory) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="genres">{{ trans('cruds.file.fields.genres') }}</label>
                    <div class="select2-purple" width="1.8rem">
                        <input type="text" class="form-control form-control-sm" name="genres" id="genres" value="" hidden/>
                        <select class="form-control form-control-sm select2" name="genres[]" id="genres" multiple>
                            @foreach(App\Models\File::GENRE_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ (in_array($key, old('genres', [])) || in_array($key, $file->genres ? old('genres', $file->genres) : old('genres', []))) ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            <div class="dropdown-divider mt-4"></div>

            <div class="row" style="position:realtive;">
                <i class="fa fa-plus ml-2 toggle-show1" style="cursor:pointer;position:absolute;" onclick="showSeg1()" data-toggle="tooltip" data-placement="top" title="Extend"></i>
                <i class="fa fa-minus ml-2 toggle-hide1" style="cursor:pointer;position:absolute;display:none;" onclick="hideSeg1()" data-toggle="tooltip" data-placement="top" title="Minimize"></i>
            </div>

            <div class="row mt-4" id="section1">
                <div class="form-group col-md-3">
                    <label for="me">{{ trans('cruds.file.fields.me') }}</label><br>
                    @foreach(App\Models\File::ME_RADIO as $key => $label)
                        <div class="icheck-primary d-inline">
                            <input type="radio" id="me_{{ $key }}" name="me" value="{{ $key }}" {{ old('me', $file->me) === (int) $key ? 'checked' : '' }}>
                            <label for="me_{{ $key }}">{{ $label }}</label>
                        </div>&nbsp;
                    @endforeach
                </div>

                <div class="form-group col-md-3">
                    <label for="khmer_dub">{{ trans('cruds.file.fields.khmer_dub') }}</label><br>
                    @foreach(App\Models\File::KHMER_DUB_RADIO as $key => $label)
                        <div class="icheck-primary d-inline">
                            <input type="radio" id="khmer_dub_{{ $key }}" name="khmer_dub" value="{{ $key }}" {{ old('khmer_dub', $file->khmer_dub) === (int) $key ? 'checked' : '' }}>
                            <label for="khmer_dub_{{ $key }}">{{ $label }}</label>
                        </div>&nbsp;
                    @endforeach
                </div>

                <div class="form-group col-md-3">
                    <label for="poster">{{ trans('cruds.file.fields.poster') }}</label><br>
                    @foreach(App\Models\File::POSTER_RADIO as $key => $label)
                        <div class="icheck-primary d-inline">
                            <input type="radio" id="poster_{{ $key }}" name="poster" value="{{ $key }}" {{ old('poster', $file->poster) === (int) $key ? 'checked' : '' }}>
                            <label for="poster_{{ $key }}">{{ $label }}</label>
                        </div>&nbsp;
                    @endforeach
                </div>

                <div class="form-group col-md-3">
                    <label for="trailer_promo">{{ trans('cruds.file.fields.trailer_promo') }}</label><br>
                    @foreach(App\Models\File::TRAILER_PROMO_RADIO as $key => $label)
                        <div class="icheck-primary d-inline">
                            <input type="radio" id="trailer_promo_{{ $key }}" name="trailer_promo" value="{{ $key }}" {{ old('trailer_promo', $file->trailer_promo) === (int) $key ? 'checked' : '' }}>
                            <label for="trailer_promo_{{ $key }}">{{ $label }}</label>
                        </div>&nbsp;
                    @endforeach
                </div>

                <div class="form-group col-md-12">
                    <label for="synopsis">{{ trans('cruds.file.fields.synopsis') }}</label><br>
                    <textarea name="synopsis" id="synopsis" class="form-control" rows="5">{{ old('synopsis', $file->synopsis) }}</textarea>
                </div>
            </div>

            <!-- <div class="dropdown-divider mt-4"></div> -->

            <div class="row mt-4">
                <div class="form-group col-md-12">
                    <label for="remark">{{ trans('cruds.file.fields.remark') }}</label><br>
                    <textarea name="remark" id="remark" class="form-control" rows="5">{{ old('remark', $file->remark) }}</textarea>
                </div>
                <div class="form-group col-md-3">
                    <label class="required" for="file_available" data-toggle="tooltip" data-placement="top" title="Yes, to make sure you have file..">{{ trans('cruds.file.fields.file_available') }}</label><br>
                    <div class="icheck-primary d-inline">
                        <input type="radio" id="file_available1" name="file_available" value="0" {{ old('synopsis',  $file->file_available) === 0 ? 'checked' : '' }}/>
                        <label for="file_available1">No</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="radio" id="file_available2" name="file_available" value="1" {{ old('synopsis',  $file->file_available) === 1 ? 'checked' : '' }}/>
                        <label for="file_available2">Yes</label>
                    </div>
                </div>
            </div>

            <div class="dropdown-divider mt-4"></div>

            <div class="row">
                <div class="form-group col-md-12">
                    <label for="seg_break">{{ trans('cruds.file.fields.segment_break') }}</label><br>
                    <input type="hidden" name="seg_break" value="0" />
                    <div class="icheck-primary d-inline">
                        <input class="custom-control-input" type="checkbox" name="seg_break" id="seg_break" value="1" {{ $file->seg_break || old('seg_break', 0) === 1 ? 'checked' : '' }}>
                        <!-- <input type="radio" id="seg_break1" name="seg_break" value="1"/> -->
                        <label for="seg_break">Have</label>
                    </div>
                </div>
                <div class="row col-12" id="break" style="display:none;">
                    @livewire('edit-segments', [
                        'file' => $file,
                        ])
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-danger float-right" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script>
    $(document).ready(function(){
        $('#seg_break').click(function(){
            if($(this).prop("checked") == true){
                $('#break').slideDown(500, function(){
                    $('#break').slideDown(500);
                });
            }
            else if($(this).prop("checked") == false){
                $('#break').slideUp(500, function(){
                    $('#break').slideUp(500);
                });
                // $('#break').css("display", $('#break').css("display") === 'none' ? '' : 'none');
            }
        });


        if($('#seg_break').prop('checked') == true){
            $('#break').css("display", $('#break').css("display") === 'none' ? '' : 'none');
        }
        else if($('#seg_break').prop('checked') == false){
            // $('#break').slideUp(500, function(){
            //     $('#break').slideUp(500);
            // });
            $('#break').css("display", $('#break').css("display") === 'none' ? 'none' : '');
        }
    });
</script>
@endsection
