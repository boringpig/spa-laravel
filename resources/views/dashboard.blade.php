@extends('layouts.app')

@section('breadcrumb')
<li>
    <i class="ace-icon fa fa-home home-icon"></i>
    <a href="{{ route('home') }}">@lang('pageTitle.dashboard')</a>
</li>
@endsection

@section('content')
    <div class="page-header">
        <h1>
            @lang('pageTitle.dashboard')
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="space-6"></div>

                <div class="col-sm-6 infobox-container">
                    <div class="infobox infobox-blue">
                        <div class="infobox-icon">
                            <i class="ace-icon fa fa-users"></i>
                        </div>

                        <div class="infobox-data">
                            <span class="infobox-data-number">{{ $user_total }}</span>
                            <div class="infobox-content">@lang('form.user')</div>
                        </div>
                    </div>

                    <div class="infobox infobox-green">
                        <div class="infobox-icon">
                            <i class="ace-icon fa fa-picture-o"></i>
                        </div>

                        <div class="infobox-data">
                            <span class="infobox-data-number">{{ $advertisement_total }}</span>
                            <div class="infobox-content">@lang('form.advertisement')</div>
                        </div>
                    </div>

                    <div class="infobox infobox-pink">
                        <div class="infobox-icon">
                            <i class="ace-icon fa fa-book"></i>
                        </div>

                        <div class="infobox-data">
                            <span class="infobox-data-number">{{ $article_total }}</span>
                            <div class="infobox-content">@lang('form.article')</div>
                        </div>
                    </div>

                    <div class="infobox infobox-red">
                        <div class="infobox-icon">
                            <i class="ace-icon fa fa-location-arrow"></i>
                        </div>

                        <div class="infobox-data">
                            <span class="infobox-data-number">{{ $areagroup_total }}</span>
                            <div class="infobox-content">@lang('form.area_group')</div>
                        </div>
                    </div>

                    <div class="infobox infobox-orange2">
                        <div class="infobox-icon">
                            <i class="ace-icon fa fa-align-justify"></i>
                        </div>

                        <div class="infobox-data">
                            <span class="infobox-data-number">{{ $category_total }}</span>
                            <div class="infobox-content">@lang('form.article_title')</div>
                        </div>
                    </div>

                    <div class="infobox infobox-blue2">
                        <div class="infobox-icon">
                            <i class="ace-icon fa fa-steam"></i>
                        </div>

                        <div class="infobox-data">
                            <span class="infobox-data-number">{{ $station_total }}</span>
                            <div class="infobox-content">@lang('form.station_quantity')</div>
                        </div>
                    </div>
                </div>

                <div class="vspace-12-sm"></div>

                <div class="col-sm-6">
                    <div class="widget-box">
                        <div class="widget-header widget-header-flat widget-header-small">
                            <h5 class="widget-title">
                                <i class="ace-icon fa fa-signal"></i>
                                @lang('page.quanzhou_counties_station_count')
                            </h5>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main">
                                <div id="piechart-placeholder"></div>
                                <div class="space-10"></div>
                                <div class="hr hr8 hr-double"></div>

                                <div class="clearfix">
                                    @forelse($station_count as $value)
                                        <div class="grid3">
                                            <span class="grey">
                                                <i class="ace-icon fa fa-steam-square fa-2x blue"></i>
                                                {{ $value['county_name'] }}
                                            </span>
                                            <h4 class="pull-right">{{ $value['count'] }}</h4>
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div><!-- /.widget-main -->
                        </div><!-- /.widget-body -->
                    </div><!-- /.widget-box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('script')
<script src="assets/js/jquery.flot.min.js"></script>
<script src="assets/js/jquery.flot.pie.min.js"></script>
<script src="assets/js/jquery.flot.resize.min.js"></script>
<script type="text/javascript">
$(function() {
    $.resize.throttleWindow = false;
    var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});
    loadingStation().done(function(data) {
        drawPieChart(placeholder, data);
    });
});

function loadingStation() {
    var defer = $.Deferred();
    $.ajax({
        type: 'get',
        url: '/kiosk-manage/kiosks/calculate-station',
        success: function (data, textStatus, jqXHR) {
            defer.resolve(data.RetVal);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            defer.reject();
        }
    });
    return defer.promise();
}

function drawPieChart(placeholder, data, position) {
    $.plot(placeholder, data, {
        series: {
            pie: {
                show: true,
                tilt:0.8,
                highlight: {
                    opacity: 0.25
                },
                stroke: {
                    color: '#fff',
                    width: 2
                },
                startAngle: 2
            }
        },
        legend: {
            show: true,
            position: position || "ne", 
            labelBoxBorderColor: null,
            margin:[-30,15]
        },
        grid: {
            hoverable: true,
            clickable: true
        }
    })

    /**
    we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
    so that's not needed actually.
    */
    placeholder.data('chart', data);
    placeholder.data('draw', drawPieChart);

    var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
    var previousPoint = null;

    placeholder.on('plothover', function (event, pos, item) {
        if(item) {
            if (previousPoint != item.seriesIndex) {
                previousPoint = item.seriesIndex;
                var tip = item.series['label'] + " : " + item.series['percent']+'%';
                $tooltip.show().children(0).text(tip);
            }
            $tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
        } else {
            $tooltip.hide();
            previousPoint = null;
        }
    });
}
</script>
@endsection