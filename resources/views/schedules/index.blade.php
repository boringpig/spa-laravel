@extends('layouts.app')

@section('breadcrumb')
<li>
    <i class="ace-icon fa fa-cogs"></i>
    @lang('pageTitle.setting-manage')
</li>
<li>
    <a href="{{ route('schedules.index') }}">@lang('pageTitle.schedules_page')</a>
</li>
@endsection

@section('content')
     <div class="page-header">
        <h1>
            @lang('pageTitle.schedules_page')
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <div class="space-10"></div>
            <!-- content -->
            <table id="simple-table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="center">@lang('form.command_name')</th>
                        <th class="center">@lang('form.description')</th>
                        <th class="center">@lang('form.frequence')</th>
                        <th class="center">@lang('form.status')</th>
                        <th class="center">@lang('form.error_message')</th>
                        <th class="center">@lang('form.last_runtime')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($commands as $command)
                        <tr>
                            <td class="center">{{ $command['command'] }}</td>
                            <td class="center">{{ $command['description'] }}</td>
                            <td class="center">{{ $command['frequence'] }}</td>
                            <td class="center">
                                @if($command['status'])
                                    <span class="label label-success label-white middle">@lang('form.normal')</span>    
                                @else
                                    <span class="label label-danger label-white middle">@lang('form.abnormal')</span>
                                @endif
                            </td>
                            <td class="center">{{ $command['error'] }}</td>
                            <td class="center">{{ $command['runtime'] }}</td>
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
    @if($commands instanceof \Illuminate\Pagination\LengthAwarePaginator)
        @include('widgets.paginate', ['data' => $commands])
    @endif
@endsection