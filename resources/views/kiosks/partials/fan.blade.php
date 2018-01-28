<div class="form-group">
    @switch($type)
        @case('into_fan1')
            <label class="editable editable-click switch-editable-fan" style="margin-left:4%"> @lang('form.into_fan1') </label>
            @break
        @case('into_fan2')
            <label style="margin-left:4%"> @lang('form.into_fan2') </label>
            @break
        @case('exhaust_fan1')
            <label class="editable editable-click switch-editable-fan" style="margin-left:4%"> @lang('form.exhaust_fan1') </label>
            @break
        @case('exhaust_fan2')
            <label style="margin-left:4%"> @lang('form.exhaust_fan2') </label>
            @break
        @case('exhaust_fan3')
            <label style="margin-left:4%"> @lang('form.exhaust_fan3') </label>
            @break
        @default
            <label class="editable editable-click switch-editable-fan" style="margin-left:4%"> @lang('form.into_fan1') </label>
            @break
    @endswitch
</div>  
<div class="form-group">
    <label for="name" class="col-sm-4"> @lang('form.launch_type') </label>
    <div class="col-sm-6">
        <select name="launch_type" id="launch_type" class="form-control" style="display:none">
            <option value="0">@lang('form.close')</option>
            <option value="1">@lang('form.open')</option>
            <option value="2">@lang('form.auto_perform')</option>
        </select>
        <div id="launch_type" style="display:block;">
            @switch($kiosk[$type]['launch'])
                @case(0)
                    <p>@lang('form.direct_perform')</p>
                    @break
                @case(1)
                    <p>@lang('form.auto_perform')</p>
                    @break
                @default
                    <p>@lang('form.direct_perform')</p>
                    @break
            @endswitch
        </div>
    </div>
</div>
<div class="form-group">
    <label for="name" class="col-sm-4"> @lang('form.action_type') </label>
    <div class="col-sm-6">
        @if(!empty($kiosk[$type]['action']) && $kiosk[$type]['action'])
            <span class="label label-success label-white middle">
                <i class="ace-icon fa fa-wrench bigger-120"></i> @lang('form.working')
            </span>
        @else 
            <span class="label label-warning label-white middle">
                <i class="ace-icon fa fa-exclamation-triangle bigger-120"></i> @lang('form.stop_working')
            </span>
        @endif
    </div>
</div>
<div class="form-group">
    <label for="name" class="col-sm-4"> @lang('form.open_temperature') </label>
    <div class="col-sm-5">
        <input type="number" class="form-control" id="open_temperature" name="open_temperature" value="{{ $kiosk[$type]['open_temperature'] }}" placeholder="@lang('form.open_temperature')" disabled> 
    </div>
</div>
<div class="form-group">
    <label for="name" class="col-sm-4"> @lang('form.close_temperature') </label>
    <div class="col-sm-5">  
        <input type="number" class="form-control" id="close_temperature" name="close_temperature" value="{{ $kiosk[$type]['close_temperature'] }}" placeholder="@lang('form.close_temperature')" disabled> 
    </div>
</div>
<div class="form-group" style="display:none;">
    <div class="col-sm-4">
        <button type="submit" class="btn btn-white btn-info btn-bold" data-loading-text="<i class='fa fa-spinner fa-spin '></i> 处理中请稍后...">
            <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>@lang('form.submit')
        </button>
    </div>
</div>