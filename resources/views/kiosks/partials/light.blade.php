<div class="form-group">
    @switch($type)
        @case('stoboard_light')
            <label for="name" class="editable editable-click switch-editable" style="margin-left:4%"> @lang('form.stoboard_light') </label>
            @break
        @case('collision_warning_light')
            <label for="name" class="editable editable-click switch-editable" style="margin-left:4%"> @lang('form.collision_warning_light') </label>
            @break
        @case('card_reader_light')
            <label for="name" class="editable editable-click switch-editable" style="margin-left:4%"> @lang('form.card_reader_light') </label>
            @break
        @default
            <label for="name" class="editable editable-click switch-editable" style="margin-left:4%"> @lang('form.card_reader_light') </label>
            @break
    @endswitch
</div>
<div class="form-group">
    <label for="name" class="col-sm-4"> @lang('form.launch_type') </label>
    <div class="col-sm-6">
        <select name="launch_type" id="launch_type" class="form-control" disabled>
            <option value="0" @if($kiosk[$type]['launch'] == "0") selected @endif>@lang('form.direct_perform')</option>
            <option value="1" @if($kiosk[$type]['launch'] == "1") selected @endif>@lang('form.auto_perform')</option>
        </select>
    </div>
</div>
<div class="form-group">
    <label for="name" class="col-sm-4"> @lang('form.action_type') </label>
    <div class="col-sm-5">
        <select name="action_type" id="action_type" class="form-control" disabled>
            <option value="0" @if($kiosk[$type]['action'] == "0") selected @endif>@lang('form.close')</option>
            <option value="1" @if($kiosk[$type]['action'] == "1") selected @endif>@lang('form.open')</option>
            <option value="2" @if($kiosk[$type]['action'] == "2") selected @endif>@lang('form.twinkling')</option>
        </select>
    </div>
</div>
<div class="form-group">
    <label for="name" class="col-sm-4"> @lang('form.start_time') </label>
    <div class="col-sm-5">
        <input type="text" class="form-control time" id="start_time" name="start_time" value="{{ $kiosk[$type]['start_time'] }}" placeholder="@lang('form.start_time')" disabled>
    </div>
</div>
<div class="form-group">
    <label for="name" class="col-sm-4"> @lang('form.end_time') </label>
    <div class="col-sm-5">
        <input type="text" class="form-control time" id="end_time" name="end_time" value="{{ $kiosk[$type]['end_time'] }}" placeholder="@lang('form.end_time')" disabled> 
    </div>
</div>
<div class="form-group" style="display:none;">
    <div class="col-sm-4">
        <button type="submit" class="btn btn-white btn-info btn-bold" data-loading-text="<i class='fa fa-spinner fa-spin '></i> 处理中请稍后...">
            <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>@lang('form.submit')
        </button>
    </div>
</div>