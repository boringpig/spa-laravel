@extends('layouts.app')

@section('breadcrumb')
<li>
    <i class="ace-icon fa fa-cogs"></i>
    @lang('pageTitle.setting-manage')
</li>
<li>
    <a href="{{ route('settings.index') }}">@lang('pageTitle.settings_page')</a>
</li>
@endsection

@section('content')
     <div class="page-header">
        <h1>
            @lang('pageTitle.settings_page')
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-offset-1 col-xs-10">
            <!-- form -->
            <form class="form-horizontal" action="{{ route('settings.store') }}" method="post">
                {{ csrf_field() }}
                <div class="tabbable">
                    <ul class="nav nav-tabs padding-16">
                        <li class="active">
                            <a data-toggle="tab" href="#edit-customer_service" aria-expanded="true">
                                <i class="green ace-icon fa fa-user bigger-125"></i>
                                @lang('form.customer_service_contact_data')
                            </a>
                        </li>

                        <li class="">
                            <a data-toggle="tab" href="#edit-kiosk_freetime" aria-expanded="false">
                                <i class="purple ace-icon fa fa-steam bigger-125"></i>
                                @lang('form.kiosk_freetime_setting')
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content profile-edit-tab-content">
                        <div id="edit-customer_service" class="tab-pane active">
                            <div class="space-10"></div>

                            <div class="form-group {{ $errors->has('customer_service_phone')? ' has-error' : '' }}">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-pass1">@lang('form.customer_service_phone')</label>

                                <div class="col-sm-3">
                                    <span class="block input-icon input-icon-right">
                                        <input type="text" class="form-control" id="customer_service_phone" name="customer_service_phone" value="{{ empty($setting['customer_service_phone'])? "" : $setting['customer_service_phone'] }}">
                                        @if($errors->has('customer_service_phone'))
                                            <i class="ace-icon fa fa-times-circle"></i>
                                        @endif
                                    </span>
                                </div>
                                @if($errors->has('customer_service_phone'))
                                    <div class="help-block col-xs-12 col-sm-reset inline">{{ $errors->first('customer_service_phone') }}</div>
                                @endif
                            </div>

                            <div class="space-4"></div>

                            <div class="form-group {{ $errors->has('customer_service_email')? ' has-error' : '' }}">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-pass2">@lang('form.customer_service_email')</label>
                                
                                <div class="col-sm-3">
                                    <span class="block input-icon input-icon-right">
                                        <input type="text" class="form-control" id="customer_service_email" name="customer_service_email" value="{{ empty($setting['customer_service_email'])? "" : $setting['customer_service_email'] }}">
                                        @if($errors->has('customer_service_email'))
                                            <i class="ace-icon fa fa-times-circle"></i>
                                        @endif
                                    </span>
                                </div>
                                @if($errors->has('customer_service_email'))
                                    <div class="help-block col-xs-12 col-sm-reset inline">{{ $errors->first('customer_service_email') }}</div>
                                @endif
                            </div>
                        </div>

                        <div id="edit-kiosk_freetime" class="tab-pane">
                            <div class="space-10"></div>
                            <div class="form-group {{ $errors->has('kiosk_freetime')? ' has-error' : '' }}">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-pass1">@lang('form.freetime')</label>

                                <div class="col-sm-3">
                                    <span class="block input-icon input-icon-right">
                                        <input type="text" class="form-control" id="kiosk_freetime" name="kiosk_freetime" value="{{ empty($setting['kiosk_freetime'])? "" : $setting['kiosk_freetime'] }}">
                                        @if($errors->has('kiosk_freetime'))
                                            <i class="ace-icon fa fa-times-circle"></i>
                                        @endif
                                    </span>
                                </div>
                                @if($errors->has('kiosk_freetime'))
                                    <div class="help-block col-xs-12 col-sm-reset inline">{{ $errors->first('kiosk_freetime') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-10"></div>
                <div class="clearfix ">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn btn-white btn-info btn-bold">
                            <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                            @lang('form.save_change')
                        </button>
                    </div>
                </div>
            </form>
            <!-- content -->
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection