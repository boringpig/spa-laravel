@extends('layouts.app')

@section('breadcrumb')
<li>
    <i class="ace-icon fa fa-users users-icon"></i>
    @lang('pageTitle.user-manage')
</li>
<li>
    <a href="{{ route('roles.index') }}">@lang('pageTitle.roles_page')</a>
</li>
@endsection

@section('content')
    <div class="page-header">
        <h1>
            @lang('pageTitle.roles_page')
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-12">
            <!-- form -->
            <form action="{{ route('roles.search') }}" method="get">
                <div class="row">
                    <div class="col-xs-3">
                        @lang('form.role_name')：
                        <input type="text" class="form-control" placeholder="@lang('form.role_name')" id="name" name="name" value="{{ old('name') }}">
                    </div>
                    <div class="col-xs-3">
                        @component('widgets.form.date')
                            @slot('title')
                                @lang('form.updated_at')
                            @endslot
                        @endcomponent
                    </div>
                    <div class="col-xs-6" style="text-align:right;margin-top: 22px;">
                        @if(in_array('search', $role_button))
                            <button type="submit" class="btn btn-white btn-default btn-bold">
                                <i class="fa fa-fw fa-search"></i>@lang('form.search')
                            </button>
                        @endif
                        @if(in_array('store', $role_button))
                            <a href="{{ route('roles.create') }}" class="btn btn-white btn-success btn-bold">
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
                        <th>@lang('form.role_name')</th>
                        <th>@lang('form.using_username')</th>
                        <th>@lang('form.updated_at')</th>
                        <th>@lang('form.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>{{ $role['name'] }}</td>
                            <td>{{ empty($role['usernames'])? "" : implode('、', $role['usernames']) }}</td>
                            <td>{{ $role['updated_at'] }}</td>
                            <td>
                                <div class="action-buttons">
                                    @if(in_array('update', $role_button))
                                        <a href="{{ route('roles.edit', ['id' => $role['id']]) }}" class="blue" data-toggle="tooltip" data-placement="bottom" title="@lang('form.edit')">
                                            <i class="ace-icon fa fa-pencil bigger-120"></i>
                                        </a>
                                    @endif
                                    @if(in_array('destroy', $role_button))
                                        <a href="" class="red" onclick="deleteRole(event,this)" data-toggle="tooltip" data-placement="bottom" title="@lang('form.delete')" data-id="{{ $role['id'] }}" data-name="{{ $role['name'] }}">
                                            <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">@lang('form.no_data')</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($roles instanceof \Illuminate\Pagination\LengthAwarePaginator)
        @include('widgets.paginate', ['data' => $roles])
    @endif
@endsection

@section('script')
<script>
    // 刪除角色
    function deleteRole(event,button) {
        event.preventDefault();
        var content = '';
        content += "<h4> @lang('form.name')：" + $(button).data('name')+ "</h4>";
        var id = $(button).data('id');
        var url = `/user-manage/roles/${id}`;
        var title = "@lang('message.are_you_sure_delete_role')";
        var redirect = "/user-manage/roles";
        var csrf_token = "{{ csrf_token() }}";
        deleteData(content,title,url,csrf_token,redirect)
    }
</script>
@endsection