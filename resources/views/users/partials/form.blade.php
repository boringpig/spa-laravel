<div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="username"> @lang('form.username') </label>
    <div class="col-sm-9">
        <input type="text" id="username" name="username" class="col-xs-10 col-sm-5" value="">
    </div>
</div>
<div class="space-4"></div>
<div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="password"> @lang('form.password') </label>
    <div class="col-sm-9">
        <input type="password" id="password" name="password" class="col-xs-10 col-sm-5" value="">
    </div>
</div>
<div class="space-4"></div>
<div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="name"> @lang('form.name') </label>
    <div class="col-sm-9">
        <input type="text" id="name" name="name" class="col-xs-10 col-sm-5" value="">
    </div>
</div>
<div class="space-4"></div>
<div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="email"> @lang('form.email') </label>
    <div class="col-sm-9">
        <input type="email" id="email" name="email" class="col-xs-10 col-sm-5" value="">
    </div>
</div>
<div class="space-4"></div>
<div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="phone"> @lang('form.phone') </label>
    <div class="col-sm-9">
        <input type="text" id="phone" name="phone" class="col-xs-10 col-sm-5" value="">
    </div>
</div>
<div class="space-4"></div>
<div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="status" style="padding-top:2px;"> @lang('form.status') </label>
    <div class="col-sm-9">
        <input id="status" name="status" class="ace ace-switch ace-switch-4 btn-empty" type="checkbox">
        <span class="lbl"></span>
    </div>
</div>
<div class="space-4"></div>

<div class="clearfix ">
    <div class="col-md-offset-3 col-md-9">
        <div class="col-md-2">
            <button class="btn btn-success" type="submit">
                <i class="ace-icon fa fa-check bigger-110"></i>
                @lang('form.submit')
            </button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('users') }}" class="btn btn-default">
                <i class="ace-icon fa fa-undo bigger-110"></i>
                @lang('form.cancel_back')
            </a>
        </div>
    </div>
</div>
                