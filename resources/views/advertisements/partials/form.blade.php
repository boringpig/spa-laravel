<div class="form-group {{ $errors->has('name')? ' has-error' : '' }}">
    <label for="name" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> <span class="text-danger">*</span> @lang('form.advertisement_name') </label>
    <div class="col-xs-3">
        <span class="block input-icon input-icon-right">
            <input type="text" id="name" name="name" class="width-100" value="{{ !empty($advertisement['name'])? $advertisement['name'] : old('name') }}">
            @if($errors->has('name'))
                <i class="ace-icon fa fa-times-circle"></i>
            @endif
        </span>
    </div>
    @if($errors->has('name'))
        <div class="help-block col-xs-12 col-sm-reset inline">{{ $errors->first('name') }}</div>
    @endif
</div>
<div class="space-4"></div>
@if(empty($advertisement['path']))
<div class="form-group {{ $errors->has('path')? ' has-error' : '' }}">
    <label for="path" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> <span class="text-danger">*</span> @lang('form.image_or_video') </label>
    <div class="col-xs-3">
        <span class="block input-icon input-icon-right">
            <input type="file" id="path" name="path" class="width-100" value="">
            @if($errors->has('path'))
                <i class="ace-icon fa fa-times-circle"></i>
            @endif
        </span>
    </div>
    @if($errors->has('path'))
        <div class="help-block col-xs-12 col-sm-reset inline">{{ $errors->first('path') }}</div>
    @endif
</div>
<div class="space-4"></div>
@endif
<div class="space-4"></div>
<div class="form-group {{ $errors->has('round_time')? ' has-error' : '' }}">
    <label for="round_time" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> <span class="text-danger">*</span> @lang('form.round_time') </label>
    <div class="col-xs-3">
        <span class="block input-icon input-icon-right">
            <input type="number" id="round_time" name="round_time" class="width-100" min="0" value="{{ !empty($advertisement['round_time'])? $advertisement['round_time'] : old('round_time') }}">
            @if($errors->has('round_time'))
                <i class="ace-icon fa fa-times-circle"></i>
            @endif
        </span>
    </div>
    @if($errors->has('round_time'))
        <div class="help-block col-xs-12 col-sm-reset inline">{{ $errors->first('round_time') }}</div>
    @endif
</div>
<div class="space-4"></div>
<div class="form-group {{ $errors->has('broadcast_area')? ' has-error' : '' }}">
    <label for="broadcast_area[]" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> <span class="text-danger">*</span> @lang('form.broadcast_area') </label>
    <div class="col-xs-4">
        <span class="block input-icon input-icon-right">
            <select multiple="" class="chosen-select form-control" id="broadcast_area[]" name="broadcast_area[]" data-placeholder="@lang('form.choose_one_area')">
                @forelse(getSCityArray() as $key => $value)
                    @if(!empty($advertisement['broadcast_area']) && in_array($key,$advertisement['broadcast_area']))
                        <option value="{{ $key }}" selected>{{ $value }}</option>
                    @else
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endif
                @empty
                @endforelse
            </select>
        </span>
    </div>
    @if($errors->has('broadcast_area'))
        <div class="help-block col-xs-12 col-sm-reset inline">{{ $errors->first('broadcast_area') }}</div>
    @endif
</div>
<div class="space-4"></div>
<div class="form-group {{ $errors->has('weeks')? ' has-error' : '' }}">
    <label for="weeks" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> <span class="text-danger">*</span> @lang('form.round_weeks') </label>
    <div class="col-xs-9">
        <span class="block input-icon input-icon-right">
            <div class="checkbox checkbox-inline" style="padding-left: 0px;margin-left:0px;">
                @foreach(config('weeks.cn') as $key => $value) 
                    <label>
                        @if(!empty($advertisement['weeks']) && in_array($key, $advertisement['weeks']))
                            <input type="checkbox" id="{{ $key }}_weeks[]" name="weeks[]" value="{{ $key }}" class="ace" checked> 
                        @else
                            <input type="checkbox" id="{{ $key }}_weeks[]" name="weeks[]" value="{{ $key }}" class="ace"> 
                        @endif
                        <span class="lbl"> {{ $value }}</span>
                    </label>
            @endforeach
                
            </div>
            
        </span>
    </div>
    @if($errors->has('weeks'))
        <div class="help-block col-xs-12 col-sm-reset inline">{{ $errors->first('weeks') }}</div>
    @endif
</div>
<div class="space-4"></div>
<div class="form-group {{ ($errors->has('broadcast_start_time') || $errors->has('broadcast_end_time'))? ' has-error' : '' }}">
    <label for="broadcast_time" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> <span class="text-danger">*</span> @lang('form.broadcast_time') </label>
    <div class="col-xs-9">
        <span class="input-icon input-icon-right">
            <input type="text" id="broadcast_time" name="broadcast_start_time" value="{{ !empty($advertisement['broadcast_start_time'])? $advertisement['broadcast_start_time'] : old('broadcast_start_time') }}">
            @if($errors->has('broadcast_start_time'))
                <i class="ace-icon fa fa-times-circle"></i>
            @endif
        </span>
        @if($errors->has('broadcast_start_time'))
            <div class="help-block col-xs-12 col-sm-reset inline">{{ $errors->first('broadcast_start_time') }}</div>
        @endif
        ~
        <span class="input-icon input-icon-right">
            <input type="text" id="broadcast_time" name="broadcast_end_time" value="{{ !empty($advertisement['broadcast_end_time'])? $advertisement['broadcast_end_time'] : old('broadcast_end_time') }}">
            @if($errors->has('broadcast_start_time'))
                <i class="ace-icon fa fa-times-circle"></i>
            @endif
        </span>
        @if($errors->has('broadcast_end_time'))
            <div class="help-block col-xs-12 col-sm-reset inline">{{ $errors->first('broadcast_end_time') }}</div>
        @endif
        
    </div>
</div>
<div class="space-4"></div>
<div class="form-group {{ $errors->has('publish_at')? ' has-error' : '' }}">
    <label for="publish_at" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> <span class="text-danger">*</span> @lang('form.publish_at') </label>
    <div class="col-xs-3">
        <span class="block input-icon input-icon-right">
            <input type="text" id="publish_at" name="publish_at" class="width-100" value="{{ !empty($advertisement['publish_at'])? $advertisement['publish_at'] : old('publish_at') }}">
            @if($errors->has('publish_at'))
                <i class="ace-icon fa fa-times-circle"></i>
            @endif
        </span>
    </div>
    @if($errors->has('publish_at'))
        <div class="help-block col-xs-12 col-sm-reset inline">{{ $errors->first('publish_at') }}</div>
    @endif
</div>
<div class="space-4"></div>
<div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="status" style="padding-top:2px;"> @lang('form.status') </label>
    <div class="col-sm-9">
        @if(!empty($advertisement) && $advertisement['status'] == 1)
            <input id="status" name="status" class="ace ace-switch ace-switch-4 btn-empty" type="checkbox" value="1" checked>
        @else
            <input id="status" name="status" class="ace ace-switch ace-switch-4 btn-empty" type="checkbox" value="0">
        @endif
        <span class="lbl"></span>
    </div>
</div>
<div class="space-10"></div>
<div class="clearfix ">
    <div class="col-md-offset-3 col-md-9">
        <button type="submit" class="btn btn-white btn-info btn-bold">
            <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
            {{ $submit_button }}
        </button>
        @if(!empty($advertisement) && in_array('change-file', $role_button))
            <button class="btn btn-white btn-warning btn-bold" type="button" data-toggle="modal" data-target="#changeFileModal">
                <i class="ace-icon fa fa-pencil bigger-110"></i>
                @lang('form.change_image_or_video')
            </button>
        @endif
        <a href="{{ route('advertisements.index') }}" class="btn btn-white btn-grey btn-bold">
            <i class="ace-icon fa fa-undo bigger-110"></i>
            @lang('form.cancel_back')
        </a>
    </div>
</div>