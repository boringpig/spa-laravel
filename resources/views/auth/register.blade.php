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

                <form action="/register" method="post">
                    {{ csrf_field() }}
                    <fieldset>
                        <div class="form-group {{ $errors->has('email')? ' has-error' : '' }}">
                            <label class="block clearfix">
                                <span class="block input-icon input-icon-right">
                                    <input type="email" class="form-control" name="email" value="" placeholder="@lang('auth.please_enter_email')" />
                                    @if($errors->has('email'))
                                        <i class="ace-icon fa fa-times-circle"></i>
                                    @else
                                        <i class="ace-icon fa fa-envelope"></i>
                                    @endif
                                </span>
                                @if($errors->has('email'))
                                    <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                @endif
                            </label>
                        </div>

                        <div class="form-group {{ $errors->has('username')? ' has-error' : '' }}">
                            <label class="block clearfix">
                                <span class="block input-icon input-icon-right">
                                    <input type="text" class="form-control" name="username" value="" placeholder="@lang('auth.please_enter_account')" />
                                    @if($errors->has('username'))
                                        <i class="ace-icon fa fa-times-circle"></i>
                                    @else
                                        <i class="ace-icon fa fa-user"></i>
                                    @endif
                                </span>
                                @if($errors->has('username'))
                                    <strong class="text-danger">{{ $errors->first('username') }}</strong>
                                @endif
                            </label>
                        </div>

                        <div class="form-group {{ $errors->has('password')? ' has-error' : '' }}">
                            <label class="block clearfix">
                                <span class="block input-icon input-icon-right">
                                    <input type="password" class="form-control" name="password" value="" placeholder="@lang('auth.please_enter_password')" />
                                    @if($errors->has('password'))
                                        <i class="ace-icon fa fa-times-circle"></i>
                                    @else
                                        <i class="ace-icon fa fa-lock"></i>
                                    @endif
                                </span>
                                @if($errors->has('password'))
                                    <strong class="text-danger">{{ $errors->first('password') }}</strong>
                                @endif
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="block clearfix">
                                <span class="block input-icon input-icon-right">
                                    <input type="password" class="form-control" name="password_confirmation" value="" placeholder="@lang('auth.please_repeat_enter_password')" />
                                    <i class="ace-icon fa fa-retweet"></i>
                                </span>
                            </label>
                        </div>

                        <div class="space-24"></div>

                        <div class="clearfix">
                            <button type="reset" class="width-30 pull-left btn btn-sm">
                                <i class="ace-icon fa fa-refresh"></i>
                                <span class="bigger-110">@lang('auth.reset_button')</span>
                            </button>

                            <button type="submit" class="width-65 pull-right btn btn-sm btn-success">
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