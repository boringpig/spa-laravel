@extends('layouts.app')

@section('breadcrumb')
<li>
    <i class="ace-icon fa fa-cogs"></i>
    @lang('pageTitle.setting-manage')
</li>
<li>
    <a href="{{ route('actionlogs.index') }}">@lang('pageTitle.actionlogs_page')</a>
</li>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.min.css') }}" />
@endsection

@section('content')
     <div class="page-header">
        <h1>
            @lang('pageTitle.actionlogs_page')
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- form -->
            <form action="{{ route('actionlogs.search') }}" method="get">
                <div class="row">
                    <div class="col-xs-4">
                        @lang('form.operate_time')：
                        <div class="input-group">
                            <input id="created_at" name="created_at" type="text" class="form-control" placeholder="@lang('form.operate_time')" value="{{ old('created_at') }}">
                            <span class="input-group-addon">
                                <i class="fa fa-clock-o bigger-110"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        @lang('form.operate_role')：
                        <select class="chosen-select width-100" id="operate_role" name="operate_role">
                            <option value="">@lang('form.all')</option>
                            @forelse(getRoleNameArray() as $key => $value)
                                @if(!empty(old('operate_role')) && ($key === old('operate_role')))
                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                @else
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endif
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="col-xs-2">
                        @lang('form.operate_user')：
                        <input type="text" class="form-control" placeholder="@lang('form.operate_user')" id="operate_user" name="operate_user" value="{{ old('operate_user') }}">
                    </div>
                    <div class="col-xs-3">
                        @lang('form.operate_menu')：
                         <select class="chosen-select width-100" id="operate_menu" name="operate_menu">
                            <option value="">@lang('form.all')</option>
                            @forelse(config('menu') as $key => $value)
                                @if(!empty(old('operate_menu')) && ($key === old('operate_menu')))
                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                @else
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endif
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-xs-12" style="text-align:right;margin-top: 22px;">
                            @if(in_array('search', $role_button))
                                <button type="submit" class="btn btn-white btn-default btn-bold">
                                    <i class="fa fa-fw fa-search"></i>@lang('form.search')
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
            <div class="space-10"></div>
            <!-- content -->
            <table id="simple-table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="center">@lang('form.operate_time')</th>
                        <th class="center">@lang('form.operate_role')</th>
                        <th class="center">@lang('form.operate_user')</th>
                        <th class="center">@lang('form.operate_menu')</th>
                        <th class="center">@lang('form.operate_event')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($actionlogs as $actionlog)
                        <tr>
                            <td class="center">{{ $actionlog['created_at'] }}</td>
                            <td class="center">{{ $actionlog['role_name'] }}</td>
                            <td class="center">{{ $actionlog['name'] }}</td>
                            <td class="center">{{ $actionlog['menu'] }}</td>
                            <td class="center">{{ $actionlog['action'] }}</td>
						</tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">@lang('form.no_data')</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div><!-- /.col -->
    </div><!-- /.row -->
    @if($actionlogs instanceof \Illuminate\Pagination\LengthAwarePaginator)
        @include('widgets.paginate', ['data' => $actionlogs])
    @endif
@endsection

@section('script')
<script src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>
<script>
    $('#created_at').daterangepicker({
        timePicker: true,
        timePicker24Hour: true,
        timePickerSeconds: true,
        autoUpdateInput: false,
        locale: {
            applyLabel: '确定',
            cancelLabel: '清除',
            format: 'YYYY/MM/DD HH:mm:ss',
        }
    });
    $('#created_at').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('YYYY/MM/DD HH:mm:ss') + ' - ' + picker.endDate.format('YYYY/MM/DD HH:mm:ss'));
    });
    $('#created_at').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });
</script>
@endsection