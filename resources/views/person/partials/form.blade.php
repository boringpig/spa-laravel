<div class="form-group {{ $errors->has('username')? ' has-error' : '' }}">
    <label for="username" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> <span class="text-danger">*</span> @lang('form.username') </label>
    <div class="col-xs-3">
        <span class="block input-icon input-icon-right">
            <input type="text" id="username" name="username" class="width-100" value="{{ !empty($person['username'])? $person['username'] : old('username') }}">
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
<div class="form-group {{ $errors->has('name')? ' has-error' : '' }}">
    <label for="name" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> <span class="text-danger">*</span> @lang('form.name') </label>
    <div class="col-xs-3">
        <span class="block input-icon input-icon-right">
            <input type="text" id="name" name="name" class="width-100" value="{{ !empty($person['name'])? $person['name'] : old('name') }}">
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
            <input type="email" id="email" name="email" class="width-100" value="{{ !empty($person['email'])? $person['email'] : old('email') }}">
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
<div class="form-group {{ $errors->has('phone')? ' has-error' : '' }}">
    <label for="phone" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> @lang('form.phone') </label>
    <div class="col-xs-3">
        <span class="block input-icon input-icon-right">
            <input type="text" id="phone" name="phone" class="width-100" value="{{ !empty($person['phone'])? $person['phone'] : old('phone') }}">
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
    <label for="role_id" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> @lang('form.role_permission') </label>
    <div class="col-xs-3">
        <h5>{{ $person['role_name'] }}</h5>
    </div>
</div>
<div class="space-4"></div>
<div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="status" style="padding-top:2px;"> @lang('form.status') </label>
    <div class="col-sm-9">
        @if($person['status'])
            <span class="label label-success label-white middle">@lang('form.enable')</span>
        @else
            <span class="label label-danger label-white middle">@lang('form.disable')</span>
        @endif
    </div>
</div>
<div class="space-10"></div>
<div class="clearfix ">
    <div class="col-md-offset-3 col-md-9">
        <button type="submit" class="btn btn-white btn-info btn-bold">
            <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
            {{ $submit_button }}
        </button>
        <button class="btn btn-white btn-warning btn-bold" type="button" data-toggle="modal" data-target="#changePasswordModal">
            <i class="ace-icon fa fa-pencil bigger-110"></i>
            @lang('form.change_password')
        </button>
    </div>
</div>