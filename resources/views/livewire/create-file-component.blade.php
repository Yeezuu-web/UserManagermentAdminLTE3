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
        {{-- <form id="frm" action="{{ route('admin.files.store') }}" method="POST" enctype="multipart/form-data"> --}}
        <form id="frm" wire:submit.prevent="store">
            @csrf
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="required" for="series_id"
                        >{{ trans('cruds.file.fields.type_of_content') }}</label>
                    <select wire:model.defer="frm.series_id" class="form-control form-control-sm" required>
                        <option value="">Please select</option>
                        @foreach ($series as $value => $key)
                            <option value="{{ $key }}" {{ old('series_id', '') === (string) $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('frm.series_id')
                    <span class="text-danger text-sm" id="type_of_content_error">
                        {{$message}}
                    </span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label class="required" for="title_of_content"
                        >{{ trans('cruds.file.fields.title_of_content') }}</label>
                    <input type="text" wire:model.defer="frm.title_of_content" id="title_of_content" class="form-control form-control-sm" required>
                    @error('frm.title_of_content')
                    <span class="text-danger text-sm" id="title_of_content_error">
                        {{$message}}
                    </span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label class="required" for="channels">{{ trans('cruds.file.fields.channel') }}</label>
                    <div class="select2-purple" wire:ignore>
                        <select class="form-control form-control-sm select2" id="selectChannels" multiple required>
                            @foreach(App\Models\File::CHANNEL_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('channels', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('channels')
                    <span class="text-danger text-sm">
                        {{$message}}
                    </span>
                    @enderror
                </div>

                <div class="form-group col-md-3" id="segments">
                    <label for="segment">{{ trans('cruds.file.fields.segment') }}</label>
                    <input class="form-control form-control-sm" type="number" wire:model.defer="frm.segment" id="segment">
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
                    <input type="number" wire:model.defer="frm.episode" id="episode" class="form-control form-control-sm" />
                </div>

                <div class="form-group col-md-3">
                    <label for="file_extension">{{ trans('cruds.file.fields.file_extension') }}</label>
                    <select wire:model.defer="frm.file_extension" id="file_extension" class="form-control form-control-sm">
                        <option value="">Please select</option>
                        @foreach(App\Models\File::FILE_EXTENSION_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('file_extension', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
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
                        <input type="text" id="duration" class="form-control form-control-sm timepicker" />
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="resolution">{{ trans('cruds.file.fields.resolution') }}</label>
                    <select wire:model.defer="frm.resolution" id="resolution" class="form-control form-control-sm">
                        <option value="">Please select</option>
                        @foreach(App\Models\File::RESOLUTION_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('resolution', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="file_size">{{ trans('cruds.file.fields.file_size') }}</label>
                    <div class="input-group">
                        <select class="form-control form-control-sm col-md-3" wire:model.defer="frm.size_type" id="size_type">
                            <option value="">Select</option>
                            @foreach(App\Models\File::SIZE_TYPE_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('size_type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <input type="number"wire:model.defer="frm.file_size" id="file_size" class="form-control form-control-sm col-md-9" />
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="path">{{ trans('cruds.file.fields.path') }}</label>
                    <input type="text" wire:model.defer="frm.path" id="path" class="form-control form-control-sm" />
                </div>

                <div class="form-group col-md-3">
                    <label for="storage">{{ trans('cruds.file.fields.storage') }}</label>
                    <select wire:model.defer="frm.storage" id="storage" class="form-control form-control-sm">
                        <option value="">Please select</option>
                        @foreach(App\Models\File::STORAGE_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('storage', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="date_recieved">{{ trans('cruds.file.fields.date_received') }} (m-d-Y)</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                        </div>
                        <input type="text" id="date_recieved" class="form-control date form-control-sm" />
                    </div>
                </div>                

                <div class="form-group col-md-3">
                    <label for="air_date">{{ trans('cruds.file.fields.air_date') }} (m-d-Y)</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                        </div>
                        <input  type="text" id="air_date" class="form-control date form-control-sm" />
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
                        <input type="text" id="year" class="form-control form-control-sm yearpicker" />
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
                        <input type="text" id="period" wire:model.defer="frm.period" class="form-control form-control-sm float-right">
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
                        <input type="text" id="start_date" class="form-control form-control-sm date" />
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
                        <input type="text" id="end_date" class="form-control form-control-sm date" />
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="types">{{ trans('cruds.file.fields.type') }}</label>
                    <div class="select2-purple" wire:ignore>
                        <select class="form-control form-control-sm select2" id="selectTypes" multiple>
                            @foreach(App\Models\File::TYPE_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('types', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="territory">{{ trans('cruds.file.fields.territory') }}</label>
                    <select wire:model.defer="frm.territory" id="territory" class="form-control form-control-sm">
                        <option value="">Please select</option>
                        @foreach(App\Models\File::TERRITORY_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('territory', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="genres">{{ trans('cruds.file.fields.genres') }}</label>
                    <div class="select2-purple" wire:ignore width="1.8rem">
                        <select class="form-control form-control-sm select2" id="selectGenres" multiple>
                            @foreach(App\Models\File::GENRE_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('genres', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
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
                            <input type="radio" id="me_{{ $key }}" name="me" wire:model.defer="frm.me" value="{{ $key }}" {{ old('me', '') === (string) $key ? 'checked' : '' }}/>
                            <label for="me_{{ $key }}">{{ $label }}</label>
                        </div>&nbsp;
                    @endforeach
                </div>

                <div class="form-group col-md-3">
                    <label for="khmer_dub">{{ trans('cruds.file.fields.khmer_dub') }}</label><br>
                    @foreach(App\Models\File::KHMER_DUB_RADIO as $key => $label)
                        <div class="icheck-primary d-inline">
                            <input type="radio" id="khmer_dub_{{ $key }}" name="khmer_dub" wire:model.defer="frm.khmer_dub" value="{{ $key }}" {{ old('khmer_dub', '') === (string) $key ? 'checked' : '' }}/>
                            <label for="khmer_dub_{{ $key }}">{{ $label }}</label>
                        </div>&nbsp;
                    @endforeach
                </div>

                <div class="form-group col-md-3">
                    <label for="poster">{{ trans('cruds.file.fields.poster') }}</label><br>
                    @foreach(App\Models\File::POSTER_RADIO as $key => $label)
                        <div class="icheck-primary d-inline">
                            <input type="radio" id="poster_{{ $key }}" name="poster" wire:model.defer="frm.poster" value="{{ $key }}" {{ old('poster', '') === (string) $key ? 'checked' : '' }}/>
                            <label for="poster_{{ $key }}">{{ $label }}</label>
                        </div>&nbsp;
                    @endforeach
                </div>

                <div class="form-group col-md-3">
                    <label for="trailer_promo">{{ trans('cruds.file.fields.trailer_promo') }}</label><br>
                    @foreach(App\Models\File::TRAILER_PROMO_RADIO as $key => $label)
                        <div class="icheck-primary d-inline">
                            <input type="radio" id="trailer_promo_{{ $key }}" name="trailer_promo" wire:model.defer="frm.trailer_promo" value="{{ $key }}" {{ old('trailer_promo', '') === (string) $key ? 'checked' : '' }}/>
                            <label for="trailer_promo_{{ $key }}">{{ $label }}</label>
                        </div>&nbsp;
                    @endforeach
                </div>

                <div class="form-group col-md-12" wire:ignore>
                    <label for="synopsis">{{ trans('cruds.file.fields.synopsis') }}</label><br>
                    <textarea wire:model.defer="frm.synopsis" id="synopsis" class="form-control" rows="5"></textarea>
                </div>
            </div>

            <!-- <div class="dropdown-divider mt-4"></div> -->

            <div class="row mt-4">
                <div class="form-group col-md-12" wire:ignore>
                    <label for="remark">{{ trans('cruds.file.fields.remark') }}</label><br>
                    <textarea wire:model.defer="frm.remark" id="remark" class="form-control" rows="5"></textarea>
                </div>
                <div class="form-group col-md-3">
                    <label class="required" for="file_available" data-toggle="tooltip" data-placement="top" title="Yes, to make sure you have file..">{{ trans('cruds.file.fields.file_available') }}</label><br>
                    <div class="icheck-primary d-inline">
                        <input type="radio" id="file_available1" name="file_available" wire:model.defer="frm.file_available" value="0"/>
                        <label for="file_available1">No</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="radio" id="file_available2" name="file_available" wire:model.defer="frm.file_available" value="1"/>
                        <label for="file_available2">Yes</label>
                    </div><br>
                    @error('frm.file_available')
                    <span class="text-danger text-sm">{{$message}}</span>
                    @enderror
                </div>
            </div>

            <div class="dropdown-divider mt-4"></div>

            <div class="row">
                <div class="form-group col-md-12">
                    <label for="seg_break">{{ trans('cruds.file.fields.segment_break') }}</label><br>
                    <input type="hidden" wire:model.defer="frm.seg_break" value="0" />
                    <div class="icheck-primary d-inline">
                        <input class="custom-control-input" type="checkbox" id="seg_break" wire:model.defer="frm.seg_break" value="1" {{ old('seg_break', 0) == 1 ? 'checked' : '' }} />
                        <label for="seg_break">Have</label>
                    </div>
                </div>
                <div class="row col-12" id="break" style="display:none;" wire:ignore.self>
                    <!-- @livewire('segments') -->
                    <div class="card col-md-12">
                        <div class="card-header">Segment</div>
                        <div class="card-body">
                            <table class="table" id="products_table">
                                <thead>
                                <tr>
                                    <th>Break</th>
                                    <th>SOM</th>
                                    <th>EOM</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($breaks as $index => $break)
                                    <tr>
                                        <td>
                                            <select name="breaks[{{$index}}][segment_id]" 
                                                wire:model="breaks.{{$index}}.segment_id"
                                                class="form-control form-control-sm">
                                                <option value="">-- choose break --</option>
                                                @foreach ($allSegments as $segment)
                                                    <option value="{{ $segment->id }}">{{ $segment->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="far fa-clock"></i>
                                                    </span>
                                                </div>
                                                <input  type="text" 
                                                        name="breaks[{{$index}}][som]" 
                                                        class="form-control form-control-sm" 
                                                        wire:model="breaks.{{$index}}.som" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="far fa-clock"></i>
                                                    </span>
                                                </div>
                                                <input  type="text" 
                                                        name="breaks[{{$index}}][eom]" 
                                                        class="form-control form-control-sm" 
                                                        wire:model="breaks.{{$index}}.eom" />
                                            </div>
                                        </td>
                                        <td>
                                            <a href="#" wire:click.prevent="removeBreak({{$index}})">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <button wire:click.prevent="addBreak()" class="btn btn-sm btn-secondary">Add Break</button>
                                </div> 
                            </div>
                        </div>
                    </div>
                        


                    {{-- @include('admin.files.break') --}}
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
@push('scripts')
<script>
    document.addEventListener('livewire:load', function () {
        $('#selectChannels').on('change', (e) => {
            @this.set('channels', $('#selectChannels').select2('val'));
        });
        $('#selectTypes').on('change', (e) => {
            @this.set('types', $('#selectTypes').select2('val'));
        });
        $('#selectGenres').on('change', (e) => {
            @this.set('genres', $('#selectGenres').select2('val'));
        });
        $('#date_recieved').on('change', (e) => {
            @this.set('date_recieved', e.target.value);
        });
        $('#air_date').on('change', (e) => {
            @this.set('air_date', e.target.value);
        });
        $('#start_date').on('change', (e) => {
            @this.set('start_date', e.target.value);
        });
        $('#end_date').on('change', (e) => {
            @this.set('end_date', e.target.value);
        });
        $('#year').on('change', (e) => {
            @this.set('year', e.target.value);
        });
        $('#duration').on('change', (e) => {
            @this.set('duration', e.target.value);
        });
    });
</script>
@endpush