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
<div class="form-group">
    <label for="role_permission" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right" style="{{ $errors->has('permission')? ' color:#D16E6C;' : '' }}"> <span class="text-danger">*</span> @lang('form.role_permission') </label>
    @if($errors->has('permission'))
        <i class="ace-icon fa fa-times-circle" style="color:#D16E6C;"></i>
        <div class="help-block col-xs-12 col-sm-reset inline" style="color:#D16E6C;">{{ $errors->first('permission') }}</div>
    @endif
    <div class="clearfix"></div>
    <div class="col-xs-offset-2 col-xs-9">
        <table id="simple-table" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="center">@lang('form.menu')</th>
                    <th class="center">@lang('form.auth_button')</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $menu_list = config('menu');
                    $button_list = config('button');
                @endphp
                @forelse($data as $menu => $button)
                <tr>
                    <td class="center">{{ $menu_list[$menu] }}</td>
                    <td>
                        <div class="checkbox checkbox-inline" style="padding-left: 0px;margin-left:0px;">
                            <label>
                                <input type="checkbox" id="{{ $menu }}_selectAll" name="{{ $menu }}_selectAll" class="ace selectAll">
                                <span class="lbl"> @lang('form.select_all')</span>
                            </label>
                            @foreach($button as $value)
                                @if(array_key_exists($value, $button_list))
                                <label>
                                    @if(!empty($role['permission']) && in_array($menu.".".$value, $role['permission']))
                                        <input type="checkbox" id="{{ $menu }}_permission[]" name="permission[]" value="{{ $menu.".".$value }}" class="ace" checked> 
                                    @else
                                        <input type="checkbox" id="{{ $menu }}_permission[]" name="permission[]" value="{{ $menu.".".$value }}" class="ace"> 
                                    @endif
                                    <span class="lbl"> {{ $button_list[$value] }}</span>
                                </label>
                                @endif
                            @endforeach
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="text-center">@lang('form.no_data')</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="clearfix ">
    <div class="col-md-offset-3 col-md-9">
        <button type="submit" class="btn btn-white btn-info btn-bold">
            <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
            {{ $submit_button }}
        </button>
        <a href="{{ route('roles.index') }}" class="btn btn-white btn-grey btn-bold">
            <i class="ace-icon fa fa-undo bigger-110"></i>
            @lang('form.cancel_back')
        </a>
    </div>
</div>