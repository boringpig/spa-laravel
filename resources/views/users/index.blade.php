@extends('layouts.app')

@section('breadcrumb')
<li>
    <i class="ace-icon fa fa-users users-icon"></i>
    @lang('pageTitle.user-manage')
</li>
<li>
    <a href="{{ route('users.index') }}">@lang('pageTitle.users_page')</a>
</li>
@endsection

@section('content')
     <div class="page-header">
        <h1>
            @lang('pageTitle.users_page')
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- form -->
            <form action="{{ route('users.search') }}" method="get">
                <div class="row">
                    <div class="col-xs-3">
                        @lang('form.status')：
                        <select class="chosen-select width-100" id="status" name="status">
                            <option value="">@lang('form.all')</option>
                            <option value="1" @if(old('status') == "1") selected @endif>@lang('form.enable')</option>
                            <option value="0" @if(old('status') == "0") selected @endif>@lang('form.disable')</option>
                        </select>
                    </div>
                    <div class="col-xs-3">
                        @lang('form.username')：
                        <input type="text" class="form-control" placeholder="@lang('form.username')" id="username" name="username" value="{{ old('username') }}">
                    </div>
                    <div class="col-xs-3">
                        @lang('form.role_name')：
                        <select class="chosen-select width-100" id="role_id" name="role_id">
                            <option value="">@lang('form.all')</option>
                            @forelse(getRoleNameArray() as $key => $value)
                                @if(!empty(old('role_id')) && ($key === old('role_id')))
                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                @else
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endif
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="col-xs-3">
                        @lang('form.updated_at')：
                        <div class="input-group">
                            <input id="updated_at" name="updated_at" type="text" class="form-control" placeholder="@lang('form.updated_at')" value="{{ old('updated_at') }}">
                            <span class="input-group-addon">
                                <i class="fa fa-clock-o bigger-110"></i>
                            </span>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-xs-12" style="text-align:right;margin-top: 22px;">
                        @if(in_array('search', $role_button))
                            <button type="submit" class="btn btn-white btn-default btn-bold">
                                <i class="fa fa-fw fa-search"></i>@lang('form.search')
                            </button>
                        @endif
                        @if(in_array('store', $role_button))
                            <a href="{{ route('users.create') }}" class="btn btn-white btn-success btn-bold">
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
                        <th>@lang('form.status')</th>
                        <th>@lang('form.username')</th>
                        <th>@lang('form.name')</th>
                        <th>@lang('form.role_name')</th>
                        <th>@lang('form.email')</th>
                        <th>@lang('form.phone')</th>
                        <th>@lang('form.updated_at')</th>
                        <th>@lang('form.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                @if($user['status'] == 1)
                                    <span class="label label-success label-white middle">@lang('form.enable')</span>    
                                @else
                                    <span class="label label-danger label-white middle">@lang('form.disable')</span>
                                @endif
                            </td>
                            <td>{{ $user['username'] }}</td>
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['role_name'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td>{{ $user['phone'] }}</td>
                            <td>{{ $user['updated_at'] }}</td>
                            <td>
                                <div class="action-buttons">
                                    @if(in_array('update', $role_button))
                                        <a href="{{ route('users.edit', ['id' => $user['id']]) }}" class="blue" data-toggle="tooltip" data-placement="bottom" title="@lang('form.edit')">
                                            <i class="ace-icon fa fa-pencil bigger-120"></i>
                                        </a>
                                    @endif
                                    @if(in_array('destroy', $role_button))
                                        <a href="" class="red" onclick="deleteUser(event,this)" data-toggle="tooltip" data-placement="bottom" title="@lang('form.delete')" data-id="{{ $user['id'] }}" data-username="{{ $user['username'] }}" data-name="{{ $user['name'] }}" data-email="{{ $user['email'] }}">
                                            <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                        </a>    
                                    @endif
                                </div>
                            </td>
						</tr>
                    @empty
                        <tr>
                            <td colspan="7">@lang('form.no_data')</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div><!-- /.col -->
    </div><!-- /.row -->
    @if($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
        @include('widgets.paginate', ['data' => $users])
    @endif
@endsection

@section('script')
<script>
    $('#updated_at').datetimepicker({
        sideBySide: true,
        format: 'YYYY-MM-DD',
    });

	// 刪除使用者
    function deleteUser(event,button) {
        event.preventDefault();
        var content = '';
        content += "<h4> @lang('form.username')：" + $(button).data('username')+ "</h4>";
        content += "<h4> @lang('form.name')：" + $(button).data('name')+ "</h4>";
        content += "<h4> @lang('form.email')：" + $(button).data('email')+ "</h4>";
        var id = $(button).data('id');
        var url = `/user-manage/users/${id}`;
        var title = "@lang('message.are_you_sure_delete_user')";
        var redirect = "/user-manage/users";
        var csrf_token = "{{ csrf_token() }}";
        deleteData(content,title,url,csrf_token,redirect)
	};
</script>
@endsection