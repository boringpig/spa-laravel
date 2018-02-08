<div class="form-group {{ $errors->has('username')? ' has-error' : '' }}">
    <label for="username" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> <span class="text-danger">*</span> @lang('form.username') </label>
    <div class="col-xs-3">
        <span class="block input-icon input-icon-right">
            <input type="text" id="username" name="username" class="width-100" value="{{ !empty($user['username'])? $user['username'] : old('username') }}">
            @if($errors->has('username'))
                <i class="ace-icon fa fa-times-circle"></i>
            @endif
        </span>
    </div>
    @if($errors->has('username'))
        <div class="help-block col-xs-12 col-sm-reset inline">{{ $errors->first('username') }}</div>
    @endif
</div>
<div class="space-4"></div>
@if(empty($user))
<div class="form-group {{ $errors->has('password')? ' has-error' : '' }}">
    <label for="password" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> <span class="text-danger">*</span> @lang('form.password') </label>
    <div class="col-xs-3">
        <span class="block input-icon input-icon-right">
            <input type="password" id="password" name="password" class="width-100" value="{{ old('password') }}">
            @if($errors->has('password'))
                <i class="ace-icon fa fa-times-circle"></i>
            @endif
        </span>
    </div>
    @if($errors->has('password'))
        <div class="help-block col-xs-12 col-sm-reset inline">{{ $errors->first('password') }}</div>
    @endif
</div>
<div class="space-4"></div>
@endif
<div class="form-group {{ $errors->has('name')? ' has-error' : '' }}">
    <label for="name" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> <span class="text-danger">*</span> @lang('form.name') </label>
    <div class="col-xs-3">
        <span class="block input-icon input-icon-right">
            <input type="text" id="name" name="name" class="width-100" value="{{ !empty($user['name'])? $user['name'] : old('name') }}">
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
<div class="form-group {{ $errors->has('email')? ' has-error' : '' }}">
    <label for="email" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> <span class="text-danger">*</span> @lang('form.email') </label>
    <div class="col-xs-3">
        <span class="block input-icon input-icon-right">
            <input type="email" id="email" name="email" class="width-100" value="{{ !empty($user['email'])? $user['email'] : old('email') }}">
            @if($errors->has('email'))
                <i class="ace-icon fa fa-times-circle"></i>
            @endif
        </span>
    </div>
    @if($errors->has('email'))
        <div class="help-block col-xs-12 col-sm-reset inline">{{ $errors->first('email') }}</div>
    @endif
</div>
<div class="space-4"></div>
<div class="form-group {{ $errors->has('role_id')? ' has-error' : '' }}">
    <label for="role_id" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> <span class="text-danger">*</span> @lang('form.role_permission') </label>
    <div class="col-xs-3">
        <span class="block input-icon input-icon-right">
            @php 
                $roles = getRoleNameArray(); 
            @endphp
            @if(!empty($roles))
                <select class="chosen-select width-100" id="role_id" name="role_id" data-placeholder="@lang('form.choose_one_a_role')">
                    <option value="">  </option>
                    @foreach($roles as $key => $value)
                        @if(!empty($user['role_id']) && $key == $user['role_id'])
                            <option value="{{ $key }}" selected>{{ $value }}</option>
                        @else
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endif
                    @endforeach
                </select>
            @endif
            @if($errors->has('role_id'))
                <i class="ace-icon fa fa-times-circle"></i>
            @endif
        </span>
    </div>
    @if($errors->has('role_id'))
        <div class="help-block col-xs-12 col-sm-reset inline">{{ $errors->first('role_id') }}</div>
    @endif
</div>
<div class="space-4"></div>
<div class="form-group {{ $errors->has('phone')? ' has-error' : '' }}">
    <label for="phone" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> @lang('form.phone') </label>
    <div class="col-xs-3">
        <span class="block input-icon input-icon-right">
            <input type="text" id="phone" name="phone" class="width-100" value="{{ !empty($user['phone'])? $user['phone'] : old('phone') }}">
            @if($errors->has('phone'))
                <i class="ace-icon fa fa-times-circle"></i>
            @endif
        </span>
    </div>
    @if($errors->has('phone'))
        <div class="help-block col-xs-12 col-sm-reset inline">{{ $errors->first('phone') }}</div>
    @endif
</div>
<div class="space-4"></div>
<div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="status" style="padding-top:2px;"> @lang('form.status') </label>
    <div class="col-sm-9">
        @if(!empty($user) && $user['status'] == 1)
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
        @if(!empty($user))
            <button class="btn btn-white btn-warning btn-bold" type="button" data-toggle="modal" data-target="#changePasswordModal">
                <i class="ace-icon fa fa-pencil bigger-110"></i>
                @lang('form.change_password')
            </button>
        @endif
        <a href="{{ route('users.index') }}" class="btn btn-white btn-grey btn-bold">
            <i class="ace-icon fa fa-undo bigger-110"></i>
            @lang('form.cancel_back')
        </a>
    </div>
</div>