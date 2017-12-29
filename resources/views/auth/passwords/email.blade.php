@extends('layouts.auth')

@section('content')
    <div id="forgot-box" class="forgot-box visible widget-box no-border">
        <div class="widget-body">
            <div class="widget-main">
                <h4 class="header red lighter bigger">
                    <i class="ace-icon fa fa-key"></i>
                    @lang('auth.forgot_password_name')
                </h4>

                <div class="space-6"></div>
                
                <form action="/password/email" method="post">
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
                            </label>
                            @if($errors->has('email'))
                                <strong class="text-danger">{{ $errors->first('email') }}</strong>
                            @endif
                        </div>

                        <div class="clearfix">
                            <button type="submit" class="width-35 pull-right btn btn-sm btn-danger">
                                <i class="ace-icon fa fa-lightbulb-o"></i>
                                <span class="bigger-110">@lang('auth.send_button')</span>
                            </button>
                        </div>
                    </fieldset>
                </form>
            </div><!-- /.widget-main -->

            <div class="toolbar center">
                <a href="{{ route('login') }}" data-target="#login-box" class="back-to-login-link">
                    @lang('auth.back_to_login_page')
                    <i class="ace-icon fa fa-arrow-right"></i>
                </a>
            </div>
        </div><!-- /.widget-body -->
    </div><!-- /.forgot-box -->
@endsection