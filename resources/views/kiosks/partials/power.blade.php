<div class="form-group">
    <div class="col-sm-5">
        @switch($type)
            @case('xps1')
                <label for="name" class="editable editable-click switch-editable-power" style="margin-top:4%;margin-left:4%"> @lang('form.XPS1') </label>
                @break
            @case('xps2')
                <label for="name" class="editable editable-click switch-editable-power" style="margin-top:4%;margin-left:4%"> @lang('form.XPS2') </label>
                @break
            @case('atur')
                <label for="name" class="editable editable-click switch-editable-power" style="margin-top:4%;margin-left:4%"> @lang('form.ATUR') </label>
                @break
            @case('router')
                <label for="name" class="editable editable-click switch-editable-power" style="margin-top:4%;margin-left:4%"> @lang('form.ROUTER') </label>
                @break
            @case('ac_sockets')
                <label for="name" class="editable editable-click switch-editable-power" style="margin-top:4%;margin-left:4%"> @lang('form.ac_sockets') </label>
                @break
            @case('fot')
                <label for="name" class="editable editable-click switch-editable-power" style="margin-top:4%;margin-left:4%"> @lang('form.fot') </label>
                @break
            @case('card_reader')
                <label for="name" class="editable editable-click switch-editable-power" style="margin-top:4%;margin-left:4%"> @lang('form.card_reader') </label>
                @break
            @case('show_screen')
                <label for="name" class="editable editable-click switch-editable-power" style="margin-top:4%;margin-left:4%"> @lang('form.show_screen') </label>
                @break
            @case('touch_function')
                <label for="name" class="editable editable-click switch-editable-power" style="margin-top:4%;margin-left:4%"> @lang('form.touch_function') </label>
                @break
            @case('camera')
                <label for="name" class="editable editable-click switch-editable-power" style="margin-top:4%;margin-left:4%"> @lang('form.camera') </label>
                @break
            @default
                <label for="name" class="editable editable-click switch-editable-power" style="margin-top:4%;margin-left:4%"> @lang('form.XPS1') </label>
                @break
        @endswitch
    </div>
    <div class="col-sm-5">
        <select name="action_type" id="action_type" class="form-control" disabled>
            <option value="0" @if($kiosk[$type]=="0" ) selected @endif @if(!in_array($type, ['show_screen','touch_function'])) disabled @endif>@lang('form.close')</option>
            <option value="1" @if($kiosk[$type]=="1" ) selected @endif>@lang('form.open')</option>
            <option value="2" @if($kiosk[$type]=="2" ) selected @endif>@lang('form.reset')</option>
        </select>
    </div>
</div>
<div class="form-group" style="display:none;">
    <div class="col-sm-4">
        <button type="submit" class="btn btn-white btn-info btn-bold" data-loading-text="<i class='fa fa-spinner fa-spin '></i> 处理中请稍后...">
            <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>@lang('form.submit')
        </button>
    </div>
</div>