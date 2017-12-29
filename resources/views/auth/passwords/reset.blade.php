@extends('layouts.auth')

@section('content')
    <div id="forgot-box" class="forgot-box visible widget-box no-border">
        <div class="widget-body">
            <div class="widget-main">
                <h4 class="header red lighter bigger">
                    <i class="ace-icon fa fa-key"></i>
                    @lang('auth.reset_password_name')
                </h4>

                <div class="space-6"></div>
                
                <form action="/password/reset" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="token" value="{{ $token }}">
                    <fieldset>
                        <div class="form-group {{ $errors->has('email')? ' has-error' : '' }}">
                            <label class="block clearfix">
                                <span class="block input-icon input-icon-right">
                                    <input type="email" class="form-control" name="email" value="{{ $email or old('email') }}" placeholder="@lang('auth.please_enter_email')" />
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

                        <div class="clearfix">
                            <button type="submit" class="width-35 pull-right btn btn-sm btn-danger">
                                <i class="ace-icon fa fa-lightbulb-o"></i>
                                <span class="bigger-110">@lang('auth.reset_password_name')</span>
                            </button>
                        </div>
                    </fieldset>
                </form>
            </div><!-- /.widget-main -->
        </div><!-- /.widget-body -->
    </div><!-- /.forgot-box -->
@endsection