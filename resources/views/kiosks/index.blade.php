@extends('layouts.app')

@section('breadcrumb')
<li>
    <i class="ace-icon fa fa-desktop"></i>
    @lang('pageTitle.kiosk-manage')
</li>
<li>
    <a href="{{ route('kiosks.index') }}">@lang('pageTitle.kiosks_page')</a>
</li>
@endsection

@section('content')
     <div class="page-header">
        <h1>
            @lang('pageTitle.kiosks_page')
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- form -->
            <form id="search-form" method="get">
                <div class="row">
                    <div class="col-xs-3">
                        @lang('form.station_number')：
                        <input type="text" class="form-control" placeholder="@lang('form.station_number')" id="sno" name="sno" value="{{ old('sno') }}">
                    </div>
                    <div class="col-xs-3">
                        @lang('form.station_name')：
                        <input type="text" class="form-control" placeholder="@lang('form.station_name')" id="sname" name="sname" value="{{ old('sname') }}">
                    </div>
                    <div class="col-xs-3">
                        @component('widgets.form.county', ['counties' => $counties])
                        @endcomponent
                    </div>
                    <div class="col-xs-3">
                        @component('widgets.form.area', ['areas' => $areas])
                        @endcomponent
                    </div>
                </div>
                <div class="space-8"></div>
                <div class="row">
                    <div class="col-xs-3">
                        @lang('form.version')：
                        <input type="text" class="form-control" placeholder="@lang('form.version')" id="version" name="version" value="{{ old('version') }}">
                    </div>
                    <div class="col-xs-9" style="text-align:right;margin-top: 22px;">
                        @if(in_array('search', $role_button))
                            <button type="submit" id="search-btn" class="btn btn-white btn-default btn-bold">
                                <i class="fa fa-fw fa-search"></i>@lang('form.search')
                            </button>
                        @endif
                        @if(in_array('export', $role_button))
                            <button type="submit" id="export-btn" class="btn btn-white btn-success btn-bold">
                                <i class="fa fa-fw fa-file"></i>@lang('form.export')
                            </button>
                        @endif
                    </div>
                </div>
            </form>
            <div class="space-10"></div>
            <!-- content -->
            <table id="simple-table" class="table table-bordered table-hover table-center">
                <thead>
                    <tr>
                        <th class="detail-col">@lang('form.details')</th>
                        <th>@lang('form.station')</th>
                        <th>@lang('form.county')</th>
                        <th>@lang('form.area')</th>
                        <th>@lang('form.ip_address')</th>
                        <th>@lang('form.kiosk_identification')</th>
                        <th>@lang('form.version')</th>
                        <th>@lang('form.connection_status')</th>
                        <th>@lang('form.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kiosks as $kiosk)
                        <tr>
                            <td>
                                <div class="action-buttons">
                                    <a href="#" class="green bigger-140 show-details-btn" title="@lang('form.details')">
                                        <i class="ace-icon fa fa-angle-double-down"></i>
                                        <span class="sr-only">Details</span>
                                    </a>
                                </div>
                            </td>
                            <td>{{ $kiosk['station_number'] }}&nbsp;{{ $kiosk['station_name'] }}</td>
                            <td>{{ $kiosk['county_name'] }}</td>
                            <td>{{ $kiosk['station_area'] }}</td>
                            <td>{{ $kiosk['station_ip'] }}</td>
                            <td>{{ $kiosk['identification'] }}</td>
                            <td>{{ $kiosk['version'] }}</td>
                            <td>
                                @if($kiosk['connection_status'] === 1)
                                    <span class="badge badge-success" style="border-radius:50%">&nbsp;</span>
                                @elseif($kiosk['connection_status'] === 0)
                                    <span class="badge badge-danger" style="border-radius:50%">&nbsp;</span>
                                @else
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                @if(in_array('update', $role_button))
                                    @if($kiosk['connection_status'] === 0)
                                        <a href="{{ route('kiosks.edit', ['station' => $kiosk['station_number']]) }}" class="blue" style="pointer-events: none;"data-toggle="tooltip" data-placement="bottom" title="@lang('form.edit')" onclick="return false;" disabled>
                                            <i class="ace-icon fa fa-pencil bigger-120"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('kiosks.edit', ['station' => $kiosk['station_number']]) }}" class="blue" data-toggle="tooltip" data-placement="bottom" title="@lang('form.edit')">
                                            <i class="ace-icon fa fa-pencil bigger-120"></i>
                                        </a>
                                    @endif
                                @endif
                                </div>
                            </td>
                        </tr>
                        
                        <tr class="detail-row">
                            <td colspan="8">
                                <div class="table-detail">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-7">
                                            <div class="space visible-xs"></div>

                                            <div class="profile-user-info profile-user-info-striped">
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> @lang('form.internal_temperature') </div>

                                                    <div class="profile-info-value">
                                                        <span>{{ $kiosk['internal_temperature'] }}</span>
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> @lang('form.internal_humidity') </div>

                                                    <div class="profile-info-value">
                                                        <span>{{ $kiosk['internal_humidity'] }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> @lang('form.external_temperature') </div>

                                                    <div class="profile-info-value">
                                                        <span>{{ $kiosk['external_temperature'] }}</span>
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> @lang('form.external_humidity') </div>

                                                    <div class="profile-info-value">
                                                        <span>{{ $kiosk['external_humidity'] }}</span>
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> @lang('form.touch_screen') </div>

                                                    <div class="profile-info-value">
                                                        <span>{{ $kiosk['touch_screen'] }}</span>
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> @lang('form.camera') </div>

                                                    <div class="profile-info-value">
                                                        <span>{{ $kiosk['camera'] }}</span>
                                                    </div>
                                                </div>

                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> @lang('form.card_reader') </div>

                                                    <div class="profile-info-value">
                                                        <span>{{ $kiosk['card_reader'] }}</span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">@lang('form.no_data')</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div><!-- /.col -->
    </div><!-- /.row -->
    @if($kiosks instanceof \Illuminate\Pagination\LengthAwarePaginator)
        @include('widgets.paginate', ['data' => $kiosks])
    @endif
@endsection

@section('script')
<script src="{{ asset('assets/js/jquery.colorbox.min.js') }}"></script>
<script>
    var scitys = [];
    $(function() {
        $('#publish_at').datetimepicker({
            sideBySide: true,
            format: 'YYYY-MM-DD',
        });

        $('#search-btn').click(function() {
            $('#search-form').prop('action', '/kiosk-manage/kiosks/search');
        });

        $('#export-btn').click(function() {
            $('#search-form').prop('action', '/kiosk-manage/kiosks/export');
        });

        $('.show-details-btn').on('click', function(e) {
            e.preventDefault();
            $(this).closest('tr').next().toggleClass('open');
            $(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
        });
        loadedScitys();
        changeCountyDropdown();
    });

    function loadedScitys() {
        $.get('/dropdown/scitys', response => scitys = response.RetVal);
    }

    function changeCountyDropdown() {
        $('#county').change(function() {
            var county = $(this).val();
            $("#area").chosen("destroy");
            $('#area').find('option:gt(0)').remove();
            if($(this).val() != "") {
                scity = scitys.filter(function (item) {
                    return item.county === county;
                });
                $.each(scity['0'].areas, function(key, value) {
                    $('#area').append(`<option value="${key}">${value}</option>`);
                });
            }
            $("#area").chosen();
        });
    }
</script>
@endsection