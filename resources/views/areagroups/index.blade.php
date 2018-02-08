@extends('layouts.app')

@section('breadcrumb')
<li>
    <i class="ace-icon fa fa-desktop"></i>
    @lang('pageTitle.kiosk-manage')
</li>
<li>
    <a href="{{ route('areagroups.index') }}">@lang('pageTitle.kiosks_areagroup_page')</a>
</li>
@endsection

@section('content')
     <div class="page-header">
        <h1>
            @lang('pageTitle.kiosks_areagroup_page')
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12" style="text-align:right;margin-top: 22px;">
                    @if(in_array('store', $role_button))
                        <a href="{{ route('areagroups.create') }}" class="btn btn-white btn-success btn-bold">
                            <i class="fa fa-fw fa-plus"></i>@lang('form.create')</button>
                        </a>
                    @endif
                </div>
            </div>
            <div class="space-10"></div>
            <!-- content -->
            <table id="simple-table" class="table table-bordered table-hover table-center">
                <thead>
                    <tr>
                        <th>@lang('form.area')</th>
                        <th>@lang('form.group')</th>
                        <th>@lang('form.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($groups as $group)
                        <tr>
                            <td>{{ $group['parent_area_name'] }}</td>
                            <td>{{ $group['child_area_name'] }}</td>
                            <td>
                                <div class="action-buttons">
                                    @if(in_array('update', $role_button))
                                        <a href="{{ route('areagroups.edit', ['id' => $group['id']]) }}" class="blue" data-toggle="tooltip" data-placement="bottom" title="@lang('form.edit')">
                                            <i class="ace-icon fa fa-pencil bigger-120"></i>
                                        </a>
                                    @endif
                                    @if(in_array('destroy', $role_button))
                                        <a href="" class="red" onclick="deleteAreaGroup(event,this)" data-toggle="tooltip" data-placement="bottom" title="@lang('form.delete')" data-id="{{ $group['id'] }}" data-parent="{{ $group['parent_area_name'] }}">
                                            <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
						</tr>
                    @empty
                        <tr>
                            <td colspan="5">@lang('form.no_data')</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div><!-- /.col -->
    </div><!-- /.row -->
    @if($groups instanceof \Illuminate\Pagination\LengthAwarePaginator)
        @include('widgets.paginate', ['data' => $groups])
    @endif
@endsection

@section('script')
<script>
	// 刪除使用者
    function deleteAreaGroup(event,button) {
        event.preventDefault();
        var content = '';
        content += "<h4> @lang('form.area')：" + $(button).data('parent')+ "</h4>";
        var id = $(button).data('id');
        var url = `/kiosk-manage/areagroups/${id}`;
        var title = "@lang('message.are_you_sure_delete_area_group')";
        var redirect = "/kiosk-manage/areagroups";
        var csrf_token = "{{ csrf_token() }}";
        deleteData(content,title,url,csrf_token,redirect)
	};
</script>
@endsection