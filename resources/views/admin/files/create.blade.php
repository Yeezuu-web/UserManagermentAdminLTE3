<div class="card">
    <div class="card-header bg-gradient-primary">
        {{ trans('global.create') }} {{ trans('cruds.file.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.files.store") }}" enctype="multipart/form-data" autocomplete="off">
            @csrf
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="required" for="series_id"
                        >{{ trans('cruds.file.fields.type_of_content') }}</label>
                    <select name="series_id" id="series_id" class="form-control form-control-sm">
                        <option value="">Please select</option>
                        @foreach ($series as $value => $key)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label class="required" for="title_of_content"
                        >{{ trans('cruds.file.fields.title_of_content') }}</label>
                    <input type="text" name="title_of_content" id="title_of_content" class="form-control form-control-sm">
                </div>

                <div class="form-group col-md-3">
                    <label class="required" for="channels">{{ trans('cruds.file.fields.channel') }}</label>
                    <div class="select2-purple">
                        <select class="form-control form-control-sm select2" name="channels[]" id="channels" multiple required>
                            @foreach(App\Models\File::CHANNEL_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('channels', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-3" id="segments">
                    <label for="segment">{{ trans('cruds.file.fields.segment') }}</label>
                    <input class="form-control form-control-sm" type="number" name="segment" id="segment">
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
                    <input type="number" name="episode" id="episode" class="form-control form-control-sm" />
                </div>

                <div class="form-group col-md-3">
                    <label for="file_extension">{{ trans('cruds.file.fields.file_extension') }}</label>
                    <select name="file_extension" id="file_extension" class="form-control form-control-sm">
                        <option value="">Please select</option>
                        <option value="MXF">MXF</option>
                        <option value="MP3">MP3</option>
                        <option value="MPEG">MPEG</option>
                        <option value="AVI">AVI</option>
                        <option value="OTHER">Other</option>
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
                        <input type="text" name="duration" id="duration" class="form-control form-control-sm timepicker" />
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="resolution">{{ trans('cruds.file.fields.resolution') }}</label>
                    <select name="resolution" id="resolution" class="form-control form-control-sm">
                        <option value="">Please select</option>
                        <option value="HD">HD</option>
                        <option value="SD">SD</option>
                        <option value="OTHER">Other</option>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="file_size">{{ trans('cruds.file.fields.file_size') }}</label>
                    <div class="input-group">
                        <select class="form-control form-control-sm col-md-3" name="series_size" id="series_size">
                            <option value="">Select</option>
                            <option value="TB">TB</option>
                            <option value="GB">GB</option>
                            <option value="MB">MB</option>
                            <option value="KB">KB</option>
                        </select>
                        <input type="number"name="file_size" id="file_size" class="form-control form-control-sm col-md-9" />
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="path">{{ trans('cruds.file.fields.path') }}</label>
                    <input type="text" name="path" id="path" class="form-control form-control-sm" />
                </div>

                <div class="form-group col-md-3">
                    <label for="storage">{{ trans('cruds.file.fields.storage') }}</label>
                    <select name="storage" id="storage" class="form-control form-control-sm">
                        <option value="">Please select</option>
                        <option value="LACIE">Lacie</option>
                        <option value="IBM">IBM</option>
                        <option value="LTO">LTO</option>
                        <option value="TAPE">Tape</option>
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
                        <input type="text" name="date_received" id="date_received" class="form-control date form-control-sm" />
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
                        <input  type="text" name="air_date" id="air_date" class="form-control date form-control-sm" />
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
                        <input type="text" name="year" id="year" class="form-control form-control-sm yearpicker" />
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="period_of_time">{{ trans('cruds.file.fields.period_of_time') }}</label>

                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-clock"></i>
                        </span>
                        </div>
                        <input type="text" name="period_of_time" class="form-control form-control-sm float-right" id="period_of_time">
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
                        <input type="text" name="start_date" id="start_date" class="form-control form-control-sm date" />
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
                        <input type="text" name="end_date" id="end_date" class="form-control form-control-sm date" />
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="types">{{ trans('cruds.file.fields.type') }}</label>
                    <div class="select2-purple">
                        <select class="form-control form-control-sm select2" name="types[]" id="types" multiple required>
                            @foreach(App\Models\File::TYPE_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('types', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="territory">{{ trans('cruds.file.fields.territory') }}</label>
                    <select name="territory" id="territory" class="form-control form-control-sm">
                        <option value="">Please select</option>
                        <option value="Cambodia">Cambodia</option>
                        <option value="Global">Global</option>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="genres">{{ trans('cruds.file.fields.genres') }}</label>
                    <div class="select2-purple" width="1.8rem">
                        <select class="form-control form-control-sm select2" name="genres[]" id="genres" multiple required>
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
                    <div class="icheck-primary d-inline">
                        <input type="radio" id="me1" name="me" value="0"/>
                        <label for="me1">No</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="radio" id="me2" name="me" value="1"/>
                        <label for="me2">Yes</label>
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="khmer_dub">{{ trans('cruds.file.fields.khmer_dub') }}</label><br>
                    <div class="icheck-primary d-inline">
                        <input type="radio" id="khmer_dub1" name="khmer_dub" value="0"/>
                        <label for="khmer_dub1">No</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="radio" id="khmer_dub2" name="khmer_dub" value="1"/>
                        <label for="khmer_dub2">Yes</label>
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="poster">{{ trans('cruds.file.fields.poster') }}</label><br>
                    <div class="icheck-primary d-inline">
                        <input type="radio" id="poster1" name="poster" value="0"/>
                        <label for="poster1">No</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="radio" id="poster2" name="poster" value="1"/>
                        <label for="poster2">Yes</label>
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="trailer_promo">{{ trans('cruds.file.fields.trailer_promo') }}</label><br>
                    <div class="icheck-primary d-inline">
                        <input type="radio" id="trailer_promo1" name="trailer_promo" value="0"/>
                        <label for="trailer_promo1">No</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="radio" id="trailer_promo2" name="trailer_promo" value="1"/>
                        <label for="trailer_promo2">Yes</label>
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label for="synopsis">{{ trans('cruds.file.fields.synopsis') }}</label><br>
                    <textarea name="synopsis" id="" class="form-control" rows="5"></textarea>
                </div>
            </div>

            <!-- <div class="dropdown-divider mt-4"></div> -->

            <div class="row mt-4">
                <div class="form-group col-md-12">
                    <label for="remark">{{ trans('cruds.file.fields.remark') }}</label><br>
                    <textarea name="remark" id="" class="form-control" rows="5"></textarea>
                </div>
                <div class="form-group col-md-3">
                    <label class="required" for="file_available" data-toggle="tooltip" data-placement="top" title="Yes, to make sure you have file..">{{ trans('cruds.file.fields.file_available') }}</label><br>
                    <div class="icheck-primary d-inline">
                        <input type="radio" id="file_available1" name="file_available" value="0"/>
                        <label for="file_available1">No</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="radio" id="file_available2" name="file_available" value="1"/>
                        <label for="file_available2">Yes</label>
                    </div>
                </div>
            </div>

            <div class="dropdown-divider mt-4"></div>

            <div class="row">
                <div class="form-group col-md-12">
                    <label for="seg_break">{{ trans('cruds.file.fields.segment_break') }}</label><br>
                    <div class="icheck-primary d-inline">
                        <input class="custom-control-input" type="checkbox" id="seg_break1" value="1">
                        <!-- <input type="radio" id="seg_break1" name="seg_break" value="1"/> -->
                        <label for="seg_break1">Have</label>
                    </div>
                </div>
                <div class="row col-12" id="break" style="display:none;">
                    <div class="form-group col-md-3">
                        <label for="som">{{ trans('cruds.file.fields.som') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-clock"></i>
                            </span>
                            </div>
                            <input type="text" name="som" id="som" class="form-control form-control-sm timepicker" />
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="eom">{{ trans('cruds.file.fields.eom') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-clock"></i>
                            </span>
                            </div>
                            <input type="text" name="eom" id="eom" class="form-control form-control-sm timepicker" />
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <a class="text-primary" style="cursor:pointer;">Add Break</a>
                    </div>
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
