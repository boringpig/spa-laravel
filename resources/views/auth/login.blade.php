@extends('layouts.auth')

@section('content')
    <div id="login-box" class="login-box visible widget-box no-border">
        <div class="widget-body">
            <div class="widget-main">
                <h4 class="header blue lighter bigger">
                    <i class="ace-icon fa fa-coffee green"></i>
                    @lang('auth.login_information')
                </h4>

                <div class="space-6"></div>

                <form>
                    <fieldset>
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

                        <div class="space"></div>

                        <div class="clearfix">
                            <label class="inline">
                                <input type="checkbox" class="ace" />
                                <span class="lbl"> @lang('auth.remember_name')</span>
                            </label>

                            <button type="button" class="width-35 pull-right btn btn-sm btn-primary">
                                <i class="ace-icon fa fa-key"></i>
                                <span class="bigger-110"> @lang('auth.login_button')</span>
                            </button>
                        </div>

                        <div class="space-4"></div>
                    </fieldset>
                </form>

                <div class="social-or-login center">
                    <span class="bigger-110">@lang('auth.other_login_name')</span>
                </div>

                <div class="space-6"></div>

                <div class="social-login center">
                    <a class="btn btn-primary">
                        <i class="ace-icon fa fa-facebook"></i>
                    </a>

                    <a class="btn btn-danger">
                        <i class="ace-icon fa fa-google-plus"></i>
                    </a>
                </div>
            </div><!-- /.widget-main -->

            <div class="toolbar clearfix">
                <div>
                    <a href="{{ route('password.request') }}" data-target="#forgot-box" class="forgot-password-link">
                        <i class="ace-icon fa fa-arrow-left"></i>
                        @lang('auth.forgot_name')
                    </a>
                </div>

                <div>
                    <a href="{{ route('register') }}" data-target="#signup-box" class="user-signup-link">
                        @lang('auth.register_name')
                        <i class="ace-icon fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div><!-- /.widget-body -->
    </div><!-- /.login-box -->
@endsection