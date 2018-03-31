<div class="row">
    <div class="col-sm-offset-2 col-sm-1">
        <h5> @lang('form.station') </h5>
    </div>
    <div class="col-xs-3">
        <h5>{{ $kiosk['station_number'] }}&nbsp;{{$kiosk['station_name']}}</h5>
    </div>
</div>
<div class="row">
    <div class="col-sm-offset-2 col-sm-1">
        <h5> @lang('form.area') </h5>
    </div>
    <div class="col-xs-3">
        <h5>{{ $kiosk['station_area'] }}</h5>
    </div>
</div>
<div class="space-4"></div>
<div class="row">
    <!--燈號控制-->
    <div class="col-sm-3" style="margin-left:12%">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">@lang('form.light_control')</h4>

                <span class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </span>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal" role="form" onsubmit="submitForm(event,this)" action="{{ route('kiosks.control-light', ['station' => $kiosk['station_number']]) }}">
                        {{ csrf_field() }}
                        <input type="hidden" id="light_type" name="light_type" value="3">
                        @include('kiosks.partials.light', ['type' => 'card_reader_light'])
                    </form>
                    <hr>
                    <form class="form-horizontal" role="form" onsubmit="submitForm(event,this)" action="{{ route('kiosks.control-light', ['station' => $kiosk['station_number']]) }}">
                        {{ csrf_field() }}
                        <input type="hidden" id="light_type" name="light_type" value="2">
                        @include('kiosks.partials.light', ['type' => 'stoboard_light'])
                    </form>
                    <hr>
                    <form class="form-horizontal" role="form" onsubmit="submitForm(event,this)" action="{{ route('kiosks.control-light', ['station' => $kiosk['station_number']]) }}">
                        {{ csrf_field() }}
                        <input type="hidden" id="light_type" name="light_type" value="4">
                        @include('kiosks.partials.light', ['type' => 'collision_warning_light'])
                    </form>
                </div>
            </div>
        </div>
    </div><!-- /.燈號控制 -->
    <div class="col-sm-3">
        <!--電源控制-->
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">@lang('form.power_control')</h4>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal" role="form" onsubmit="submitForm(event,this)" action="{{ route('kiosks.control-power', ['station' => $kiosk['station_number']]) }}">
                        {{ csrf_field() }}
                        <input type="hidden" id="power_type" name="power_type" value="1"> 
                        @include('kiosks.partials.power', ['type' => 'xps1'])
                    </form>
                    <form class="form-horizontal" role="form" onsubmit="submitForm(event,this)" action="{{ route('kiosks.control-power', ['station' => $kiosk['station_number']]) }}">
                        {{ csrf_field() }}
                        <input type="hidden" id="power_type" name="power_type" value="2"> 
                        @include('kiosks.partials.power', ['type' => 'xps2'])
                    </form>
                    <form class="form-horizontal" role="form" onsubmit="submitForm(event,this)" action="{{ route('kiosks.control-power', ['station' => $kiosk['station_number']]) }}">
                        {{ csrf_field() }}
                        <input type="hidden" id="power_type" name="power_type" value="8"> 
                        @include('kiosks.partials.power', ['type' => 'atur'])
                    </form>
                    <form class="form-horizontal" role="form" onsubmit="submitForm(event,this)" action="{{ route('kiosks.control-power', ['station' => $kiosk['station_number']]) }}">
                        {{ csrf_field() }}
                        <input type="hidden" id="power_type" name="power_type" value="7"> 
                        @include('kiosks.partials.power', ['type' => 'router'])
                    </form>
                    <form class="form-horizontal" role="form" onsubmit="submitForm(event,this)" action="{{ route('kiosks.control-power', ['station' => $kiosk['station_number']]) }}">
                        {{ csrf_field() }}
                        <input type="hidden" id="power_type" name="power_type" value="9"> 
                        @include('kiosks.partials.power', ['type' => 'ac_sockets'])
                    </form>
                    <form class="form-horizontal" role="form" onsubmit="submitForm(event,this)" action="{{ route('kiosks.control-power', ['station' => $kiosk['station_number']]) }}">
                        {{ csrf_field() }}
                        <input type="hidden" id="power_type" name="power_type" value="A"> 
                        @include('kiosks.partials.power', ['type' => 'fot'])
                    </form>
                    <form class="form-horizontal" role="form" onsubmit="submitForm(event,this)" action="{{ route('kiosks.control-power', ['station' => $kiosk['station_number']]) }}">
                        {{ csrf_field() }}
                        <input type="hidden" id="power_type" name="power_type" value="3"> 
                        @include('kiosks.partials.power', ['type' => 'card_reader'])
                    </form>
                    <form class="form-horizontal" role="form" onsubmit="submitForm(event,this)" action="{{ route('kiosks.control-power', ['station' => $kiosk['station_number']]) }}">
                        {{ csrf_field() }}
                        <input type="hidden" id="power_type" name="power_type" value="5"> 
                        @include('kiosks.partials.power', ['type' => 'show_screen'])
                    </form>
                    <form class="form-horizontal" role="form" onsubmit="submitForm(event,this)" action="{{ route('kiosks.control-power', ['station' => $kiosk['station_number']]) }}">
                        {{ csrf_field() }}
                        <input type="hidden" id="power_type" name="power_type" value="6"> 
                        @include('kiosks.partials.power', ['type' => 'touch_function'])
                    </form>
                    <form class="form-horizontal" role="form" onsubmit="submitForm(event,this)" action="{{ route('kiosks.control-power', ['station' => $kiosk['station_number']]) }}">
                        {{ csrf_field() }}
                        <input type="hidden" id="power_type" name="power_type" value="4"> 
                        @include('kiosks.partials.power', ['type' => 'camera'])
                    </form>
                   
                </div>
            </div>
        </div><!-- /.電源控制 -->
        <!--門位狀態-->
        <div class="widget-box" style="margin-top:10%;">
            <div class="widget-header">
                <h4 class="widget-title">@lang('form.door_status')</h4>

                <span class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </span>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <label for="name" class="col-sm-7"> @lang('form.outside_lock_door_status') </label>
                        <div class="col-sm-5">
                            @if(!empty($kiosk['outside_lock_door_status']) && $kiosk['outside_lock_door_status'])
                                <span class="label label-success label-white middle">
                                    <i class="ace-icon fa fa-unlock bigger-120"></i> @lang('form.open')
                                </span>
                            @else 
                                <span class="label label-danger label-white middle">
                                    <i class="ace-icon fa fa-lock bigger-120"></i> @lang('form.lock')
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <label for="name" class="col-sm-7"> @lang('form.outside_door_status') </label>
                        <div class="col-sm-5">
                            @if(!empty($kiosk['outside_door_status']) && $kiosk['outside_door_status'])
                                <span class="label label-success label-white middle">
                                    <i class="ace-icon fa fa-unlock bigger-120"></i> @lang('form.open')
                                </span>
                            @else
                                <span class="label label-danger label-white middle">
                                    <i class="ace-icon fa fa-lock bigger-120"></i> @lang('form.lock')
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <label for="name" class="col-sm-7"> @lang('form.inside_door_status') </label>
                        <div class="col-sm-5">
                            @if(!empty($kiosk['inside_door_status']) && $kiosk['inside_door_status'])
                                <span class="label label-success label-white middle">
                                    <i class="ace-icon fa fa-unlock bigger-120"></i> @lang('form.open')
                                </span>
                            @else
                                <span class="label label-danger label-white middle">
                                    <i class="ace-icon fa fa-lock bigger-120"></i> @lang('form.lock')
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <label for="name" class="col-sm-7"> @lang('form.outside_door_power_socket_status') </label>
                        <div class="col-sm-5">
                            @if(!empty($kiosk['outside_door_power_socket_status']) && $kiosk['outside_door_power_socket_status'])
                                <span class="label label-success label-white middle">
                                    <i class="ace-icon fa fa-unlock bigger-120"></i> @lang('form.open')
                                </span>
                            @else
                                <span class="label label-danger label-white middle">
                                    <i class="ace-icon fa fa-lock bigger-120"></i> @lang('form.lock')
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.門位狀態 -->
    </div>
    <!--風扇控制-->
    <div class="col-sm-3">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">@lang('form.fan_control')</h4>
                <span class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </span>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal" role="form" onsubmit="submitForm(event,this)" action="{{ route('kiosks.control-fan', ['station' => $kiosk['station_number']]) }}">
                        {{ csrf_field() }}
                        <input type="hidden" id="fan_type" name="fan_type" value="0">
                        @include('kiosks.partials.fan', ['type' => 'into_fan1'])
                    </form>
                    <hr>
                    <form class="form-horizontal" role="form" onsubmit="submitForm(event,this)" action="{{ route('kiosks.control-fan', ['station' => $kiosk['station_number']]) }}">
                        {{ csrf_field() }}
                        @include('kiosks.partials.fan', ['type' => 'into_fan2'])
                    </form>
                    <hr>
                    <form class="form-horizontal" role="form" onsubmit="submitForm(event,this)" action="{{ route('kiosks.control-fan', ['station' => $kiosk['station_number']]) }}">
                        {{ csrf_field() }}
                        <input type="hidden" id="fan_type" name="fan_type" value="1">
                        @include('kiosks.partials.fan', ['type' => 'exhaust_fan1'])
                    </form>
                    <hr>
                    <form class="form-horizontal" role="form" onsubmit="submitForm(event,this)" action="{{ route('kiosks.control-fan', ['station' => $kiosk['station_number']]) }}">
                        {{ csrf_field() }}
                        @include('kiosks.partials.fan', ['type' => 'exhaust_fan2'])
                    </form>
                    <hr>
                    <form class="form-horizontal" role="form" onsubmit="submitForm(event,this)" action="{{ route('kiosks.control-fan', ['station' => $kiosk['station_number']]) }}">
                        {{ csrf_field() }}
                        @include('kiosks.partials.fan', ['type' => 'exhaust_fan3'])
                    </form>
                </div>
            </div>
        </div>
    </div><!-- /.風扇控制 -->
</div><!-- /.row -->