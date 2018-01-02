@extends('layouts.app')

@section('breadcrumb')
<li>
    <i class="ace-icon fa fa-users users-icon"></i>
    @lang('pageTitle.users_manage')
</li>
<li>
    <a href="{{ route('users') }}">@lang('pageTitle.users_page')</a>
</li>
@endsection

@section('content')
    <div class="page-header">
        <h1>
            @lang('pageTitle.users_page')
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                @lang('form.create')
            </small>
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-12">
            <form id="create_form" class="form-horizontal" role="form" method="post">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="username"> @lang('form.username') </label>
                    <div class="col-sm-9">
                        <input type="text" id="username" name="username" class="col-xs-10 col-sm-5" value="{{ old('username') }}">
                    </div>
                </div>
                <div class="space-4"></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="password"> @lang('form.password') </label>
                    <div class="col-sm-9">
                        <input type="password" id="password" name="password" class="col-xs-10 col-sm-5" value="{{ old('password') }}">
                    </div>
                </div>
                <div class="space-4"></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="name"> @lang('form.name') </label>
                    <div class="col-sm-9">
                        <input type="text" id="name" name="name" class="col-xs-10 col-sm-5" value="{{ old('name') }}">
                    </div>
                </div>
                <div class="space-4"></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="email"> @lang('form.email') </label>
                    <div class="col-sm-9">
                        <input type="email" id="email" name="email" class="col-xs-10 col-sm-5" value="{{ old('email') }}">
                    </div>
                </div>
                <div class="space-4"></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="phone"> @lang('form.phone') </label>
                    <div class="col-sm-9">
                        <input type="text" id="phone" name="phone" class="col-xs-10 col-sm-5" value="{{ old('phone') }}">
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
                
            </form>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(function() {
        $('#create_form').submit(function(event) {
            event.preventDefault();
            form_data = {
                'username': $('#username').val(),
                'password': $('#password').val(),
                'name': $('#name').val(),
                'email': $('#email').val(),
                'phone': $('#phone').val(),
                'status': $('#status').val(),
                '_token': "{{ csrf_token() }}",
            };
            $.ajax({
                type:'POST',
                url:'/api/users',
                data: form_data,
                success: function (data, textStatus, jqXHR) {
                    console.log(data);
                    //location.href('/user-manage/users');
                },
                error:  function (jqXHR, textStatus, errorThrown) {
                    //資料驗證失敗
			        if(jqXHR.status == 422) {
                        var errors = jqXHR.responseJSON.errors;
                        var msg = '';
                        $.each(errors, function(key,val) {
                            msg += '<li><strong class="text-danger">' + val + '</strong></li>';
                        });
                        showValidationDialog(msg);
                    }
                    
                }
            });
        });
    });
</script>
@endsection