@extends('layouts.auth')

@section('content')
    <div id="signup-box" class="signup-box visible widget-box no-border">
        <div class="widget-body">
            <div class="widget-main">
                <h4 class="header green lighter bigger">
                    <i class="ace-icon fa fa-users blue"></i>
                    @lang('auth.register_information')
                </h4>

                <div class="space-6"></div>

                <form>
                    <fieldset>
                        <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                                <input type="email" class="form-control" placeholder="@lang('auth.please_enter_email')" />
                                <i class="ace-icon fa fa-envelope"></i>
                            </span>
                        </label>

                        <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                                <input type="text" class="form-control" placeholder="@lang('auth.please_enter_account')" />
                                <i class="ace-icon fa fa-user"></i>
                            </span>
                        </label>

                        <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                                <input type="password" class="form-control" placeholder="@lang('auth.please_enter_password')" />
                                <i class="ace-icon fa fa-lock"></i>
                            </span>
                        </label>

                        <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                                <input type="password" class="form-control" placeholder="@lang('auth.please_repeat_enter_password')" />
                                <i class="ace-icon fa fa-retweet"></i>
                            </span>
                        </label>

                        <div class="space-24"></div>

                        <div class="clearfix">
                            <button type="reset" class="width-30 pull-left btn btn-sm">
                                <i class="ace-icon fa fa-refresh"></i>
                                <span class="bigger-110">@lang('auth.reset_button')</span>
                            </button>

                            <button type="button" class="width-65 pull-right btn btn-sm btn-success">
                                <span class="bigger-110">@lang('auth.register_button')</span>

                                <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                            </button>
                        </div>
                    </fieldset>
                </form>
            </div>

            <div class="toolbar center">
                <a href="{{ route('login') }}" data-target="#login-box" class="back-to-login-link">
                    <i class="ace-icon fa fa-arrow-left"></i>
                    @lang('auth.back_to_login_page')
                </a>
            </div>
        </div><!-- /.widget-body -->
    </div><!-- /.signup-box -->
@endsection