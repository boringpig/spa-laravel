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

                <form action="/login" method="post">
                    {{ csrf_field() }}
                    <fieldset>
                        <div class="form-group {{ $errors->has('username')? ' has-error' : '' }}">
                            <label class="block clearfix">
                                <span class="block input-icon input-icon-right">
                                    <input type="text" class="form-control" id="username" name="username" value="" placeholder="@lang('auth.please_enter_account')" />
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

                        <div class="space"></div>

                        <div class="clearfix">
                            <label class="inline">
                                <input type="checkbox" class="ace" name="remember"/>
                                <span class="lbl"> @lang('auth.remember_name')</span>
                            </label>

                            <button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
                                <i class="ace-icon fa fa-key"></i>
                                <span class="bigger-110"> @lang('auth.login_button')</span>
                            </button>
                        </div>

                        <div class="space-4"></div>
                    </fieldset>
                </form>

            </div><!-- /.widget-main -->
        </div><!-- /.widget-body -->
    </div><!-- /.login-box -->
@endsection