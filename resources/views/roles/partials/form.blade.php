<div class="form-group {{ $errors->has('name')? ' has-error' : '' }}">
    <label for="name" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> <span class="text-danger">*</span> @lang('form.role_name') </label>
    <div class="col-xs-3">
        <span class="block input-icon input-icon-right">
            <input type="text" id="name" name="name" class="width-100" value="{{ empty($role['name'])? old('name') : $role['name'] }}">
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
<label for="role_permission" style="margin-left:177px; {{ $errors->has('permission')? ' color:#D16E6C;' : '' }}"> <span class="text-danger">*</span> @lang('form.role_permission') </label>
@if($errors->has('permission'))
    <i class="ace-icon fa fa-times-circle" style="color:#D16E6C;"></i>
    <div class="help-block col-xs-12 col-sm-reset inline" style="color:#D16E6C;">{{ $errors->first('permission') }}</div>
@endif
<table id="simple-table" class="table table-bordered table-hover" style="margin-left:177px;width:800px;">
    <thead>
        <tr>
            <th class="center">@lang('form.menu')</th>
            <th class="center">@lang('form.auth_button')</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $menu => $button)
            <tr>
                <td class="center">{{ $menu_list[$menu] }}</td>
                <td>
                <div class="checkbox-inline">          
                    <input type="checkbox" id="{{ $menu }}_selectAll" name="{{ $menu }}_selectAll">          
                    <label for="checkbox">@lang('form.select_all')</label> 
                </div>
                @foreach($button as $value)
                    @if(array_key_exists($value, $button_list))
                        <div class="checkbox-inline">    
                            @if(!empty($role['permission']) && in_array($menu.".".$value, $role['permission']))
                                <input type="checkbox" id="{{ $menu }}_permission[]" name="permission[]" value="{{ $menu.".".$value }}" checked>          
                            @else 
                                <input type="checkbox" id="{{ $menu }}_permission[]" name="permission[]" value="{{ $menu.".".$value }}">          
                            @endif
                            <label for="{{ $menu }}_permission[]">{{ $button_list[$value] }}</label> 
                        </div>
                    @endif
                @endforeach
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="2" class="text-center">@lang('form.no_data')</td>
            </tr>
        @endforelse
    </tbody>
</table>
<div class="clearfix ">
    <div class="col-md-offset-3 col-md-9">
        <button class="btn btn-primary btn-sm" type="submit">
            <i class="ace-icon fa fa-check bigger-110"></i>
            {{ $submit_button }}
        </button>
        <a href="{{ route('roles.index') }}" class="btn btn-grey btn-sm">
            <i class="ace-icon fa fa-undo bigger-110"></i>
            @lang('form.cancel_back')
        </a>
    </div>
</div>