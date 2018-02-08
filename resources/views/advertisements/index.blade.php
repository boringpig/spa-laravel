@extends('layouts.app')

@section('breadcrumb')
<li>
    <i class="ace-icon fa fa-picture-o"></i>
    @lang('pageTitle.advertisement-manage')
</li>
<li>
    <a href="{{ route('advertisements.index') }}">@lang('pageTitle.advertisements_page')</a>
</li>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/colorbox.min.css') }}" />
@endsection

@section('content')
     <div class="page-header">
        <h1>
            @lang('pageTitle.advertisements_page')
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- form -->
            <form action="{{ route('advertisements.search') }}" method="get">
                <div class="row">
                    <div class="col-xs-3">
                        @lang('form.advertisement_name')：
                        <input type="text" class="form-control" placeholder="@lang('form.name')" id="name" name="name" value="{{ old('name') }}">
                    </div>
                    <div class="col-xs-3">
                        @lang('form.status')：
                        <select class="chosen-select width-100" id="status" name="status">
                            <option value="">@lang('form.all')</option>
                            <option value="1" @if(old('status') == '1') selected @endif>@lang('form.broadcast')</option>
                            <option value="0" @if(old('status') == '0') selected @endif>@lang('form.broadcast_off')</option>
                        </select>
                    </div>
                    <div class="col-xs-3">
                        @lang('form.round_time')：
                        <input type="number" class="form-control" placeholder="@lang('form.round_time')" id="round_time" name="round_time" value="{{ old('round_time') }}"
                            min="0">
                    </div>
                    <div class="col-xs-3">
                        @lang('form.publish_at')：
                        <div class="input-group">
                            <input id="publish_at" name="publish_at" type="text" class="form-control" placeholder="@lang('form.publish_at')" value="{{ old('publish_at') }}">
                            <span class="input-group-addon">
                                <i class="fa fa-clock-o bigger-110"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="space-8"></div>
                <div class="row">
                    <div class="col-xs-12" style="text-align:right;margin-top: 22px;">
                        @if(in_array('search', $role_button))
                            <button type="submit" class="btn btn-white btn-default btn-bold">
                                <i class="fa fa-fw fa-search"></i>@lang('form.search')
                            </button>
                        @endif
                        @if(in_array('store', $role_button))
                            <a href="{{ route('advertisements.create') }}" class="btn btn-white btn-success btn-bold">
                                <i class="fa fa-fw fa-plus"></i>@lang('form.create')</button>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
            <div class="space-10"></div>
            <!-- content -->
            <table id="simple-table" class="table table-bordered table-hover table-center">
                <thead>
                    <tr>
                        <th width="5%">@lang('form.status')</th>
                        <th width="5%">@lang('form.preview_image')</th>
                        <th width="12%">@lang('form.advertisement_name')</th>
                        <th width="5%">@lang('form.round_time')</th>
                        <th width="17%">@lang('form.round_weeks')</th>
                        <th width="12%">@lang('form.broadcast_area')</th>
                        <th width="12%">@lang('form.broadcast_time')</th>
                        <th width="10%">@lang('form.publish_at')</th>
                        <th width="16%">@lang('form.updated_at')</th>
                        <th width="10%">@lang('form.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($advertisements as $advertisement)
                        <tr>
                            <td>
                                <label>
                                @if($advertisement['status'] == 1)
                                    <input name="switch-status" class="ace ace-switch ace-switch-4 btn-empty" type="checkbox" data-id="{{ $advertisement['id'] }}" value="1" checked>
                                @else
                                    <input name="switch-status" class="ace ace-switch ace-switch-4 btn-empty" type="checkbox" data-id="{{ $advertisement['id'] }}" value="0">
                                @endif
                                    <span class="lbl"></span>
                                </label>
                            </td>
                            <td>
                                <ul class="ace-thumbnails clearfix">
                                    <li>
                                        <a href="{{ $advertisement['path'] }}" data-rel="colorbox" class="cboxElement">
                                        <img src="{{ $advertisement['path'] }}" width="120" height="100" alt="{{ $advertisement['name'] }}">
                                        <div class="text">
                                            <div class="inner">{{ $advertisement['name'] }}</div>
                                        </div>
                                        </a>
                                    </li>
                                </ul>
                                
                            </td>
                            <td>{{ $advertisement['name'] }}</td>
                            <td>{{ $advertisement['round_time'] }}</td>
                            <td>
                                @foreach($advertisement['weeks'] as $value)
                                    <span class="badge badge-success">{{ array_get(config('weeks'), "cn.{$value}", "") }}</span>
                                @endforeach
                            </td>
                            <td>
                                @php 
                                    $scitys = getSCityArray();
                                @endphp
                                @foreach($advertisement['broadcast_area'] as $value)
                                    <span class="label label-grey middle">{{ array_get($scitys, $value, "") }}</span>
                                @endforeach
                            </td>                            
                            <td>{{ $advertisement['broadcast_time'] }}</td>
                            <td>{{ $advertisement['publish_at'] }}</td>
                            <td>{{ $advertisement['updated_at'] }}</td>
                            <td>
                                <div class="action-buttons">
                                    @if(in_array('update', $role_button))
                                        <a href="{{ route('advertisements.edit', ['id' => $advertisement['id']]) }}" class="blue" data-toggle="tooltip" data-placement="bottom" title="@lang('form.edit')">
                                            <i class="ace-icon fa fa-pencil bigger-120"></i>
                                        </a>
                                    @endif
                                    @if(in_array('destroy', $role_button))
                                        <a href="" class="red" onclick="deleteAdvertisement(event,this)" data-toggle="tooltip" data-placement="bottom" title="@lang('form.delete')" data-id="{{ $advertisement['id'] }}" data-name="{{ $advertisement['name'] }}" >
                                            <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                        </a>
                                    @endif
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
    @if($advertisements instanceof \Illuminate\Pagination\LengthAwarePaginator)
        @include('widgets.paginate', ['data' => $advertisements])
    @endif
@endsection

@section('script')
<script src="{{ asset('assets/js/jquery.colorbox.min.js') }}"></script>
<script>
    $(function() {
        initialColorBox();
        $('#publish_at').datetimepicker({
            sideBySide: true,
            format: 'YYYY-MM-DD',
        });
    });

    $('input[name="switch-status"]').change(function () {
        var id = $(this).data('id');
        var csrf_token = "{{ csrf_token() }}";
        var status = 0;
        if ($(this).prop('checked')) {
            status = 1;
        } 
        $.ajax({
            type: 'POST',
            url: `/advertisement-manage/advertisements/change-status/${id}`,
            data: {"_token": csrf_token,"status": status},
            success: function (data, textStatus, jqXHR) {
                successMessage("@lang('message.change_status_success')");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status == 500) {
                    errorMessage(jqXHR.responseJSON.errors);
                }
            }
        });
    });

    // 刪除使用者
    function deleteAdvertisement(event,button) {
        event.preventDefault();
        var content = '';
        content += "<h4> @lang('form.advertisement_name')：" + $(button).data('name') + "</h4>";
        var id = $(button).data('id');
        var url = `/advertisement-manage/advertisements/${id}`;
        var title = "@lang('message.are_you_sure_delete_advertisement')";
        var redirect = "/advertisement-manage/advertisements";
        var csrf_token = "{{ csrf_token() }}";
        deleteData(content, title, url, csrf_token, redirect)
    };

    function initialColorBox() {
        var $overflow = '';
        var colorbox_params = {
            rel: 'colorbox',
            reposition:true,
            scalePhotos:true,
            scrolling:false,
            previous:'<i class="ace-icon fa fa-arrow-left"></i>',
            next:'<i class="ace-icon fa fa-arrow-right"></i>',
            close:'&times;',
            current:'{current} of {total}',
            maxWidth:'100%',
            maxHeight:'100%',
            onOpen:function(){
                $overflow = document.body.style.overflow;
                document.body.style.overflow = 'hidden';
            },
            onClosed:function(){
                document.body.style.overflow = $overflow;
            },
            onComplete:function(){
                $.colorbox.resize();
            }
        };

        $('.ace-thumbnails [data-rel="colorbox"]').colorbox(colorbox_params);
        $("#cboxLoadingGraphic").html("<i class='ace-icon fa fa-spinner orange fa-spin'></i>");//let's add a custom loading icon
        
        
        $(document).one('ajaxloadstart.page', function(e) {
            $('#colorbox, #cboxOverlay').remove();
        });
    }
</script>
@endsection