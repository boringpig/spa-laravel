@extends('layouts.app')

@section('breadcrumb')
<li>
    <i class="ace-icon fa fa-users users-icon"></i>
    @lang('pageTitle.kiosks_manage')
</li>
<li>
    <a href="{{ route('kiosks.index') }}">@lang('pageTitle.kiosks_page')</a>
</li>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-timepicker.min.css') }}" />
@endsection

@section('content')
    <div class="page-header">
        <h1>
            @lang('pageTitle.kiosks_page')
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                @lang('form.edit')
            </small>
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-12">
            @include('kiosks.partials.form', ['kiosk' => $kiosk])
        </div>
    </div>
@endsection

@section('script')
<script src="{{ asset('assets/js/bootstrap-timepicker.min.js') }}"></script>
<script>
$(function() {
    $('.time').timepicker({
        minuteStep: 1,
        showMeridian: false,
        disableFocus: true,
        defaultTime: false,
        icons: {
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down'
        }
    });

    $('.switch-editable').on('click', function (e) {
        e.preventDefault();
        var parent = $(this).closest('div.form-group');
        var start_time = parent.next().next().next().find('input[id="start_time"]');
        var end_time = parent.next().next().next().next().find('input[id="end_time"]');
        var launch_type = parent.next().find('select[id="launch_type"]');
        var action_type = parent.next().next().find('select[id="action_type"]');
        launch_type.prop('disabled', !launch_type.prop('disabled'));
        action_type.prop('disabled', !action_type.prop('disabled'));
        start_time.prop('disabled', !start_time.prop('disabled'));
        end_time.prop('disabled', !end_time.prop('disabled'));
        parent.next().next().next().next().next().toggle();
    });

    $('.switch-editable-power').on('click', function(e) {
        e.preventDefault();
        var parent = $(this).closest('div.form-group');
        var action_type = parent.find('select[id="action_type"]');
        action_type.prop('disabled', !action_type.prop('disabled'));
        parent.next().toggle();
    });

    $('.switch-editable-fan').on('click', function(e) {
        e.preventDefault();
        var parent = $(this).closest('div.form-group');
        var open_temperature = parent.next().next().next().find('input[id="open_temperature"]');
        var close_temperature = parent.next().next().next().next().find('input[id="close_temperature"]');
        parent.next().find('select[id="launch_type"]').toggle();
        parent.next().find('div[id="launch_type"]').toggle();
        open_temperature.prop('disabled', !open_temperature.prop('disabled'));
        close_temperature.prop('disabled', !close_temperature.prop('disabled'));
        parent.next().next().next().next().next().toggle();
    });
});

function submitForm(e,form) {
    e.preventDefault();
    var url = $(form).attr('action');
    var param = $(form).serialize();
    var load_btn = $(form).find('.btn');
    load_btn.button('loading');
    $.ajax({
        type: 'POST',
        url: url,
        data: param,
        success: function (data, textStatus, jqXHR) {
            successMessage("@lang('message.change_status_success')");
            load_btn.button('reset');
            location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status == 500) {
                errorMessage(jqXHR.responseJSON.errors);
                load_btn.button('reset');
            }
        }
    });
}
</script>
@endsection