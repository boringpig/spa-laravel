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
                        <select class="form-control" id="status" name="status">
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
                        @if(!empty($roles))
                            <select class="chosen-select width-100" id="role_id" name="role_id" data-placeholder="@lang('form.choose_one_a_role')">
                                <option value="">  </option>
                                @foreach($roles as $key => $value)
                                    @if(!empty(old('role_id')) && ($key === old('role_id')))
                                        <option value="{{ $key }}" selected>{{ $value }}</option>
                                    @else
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endif
                                @endforeach
                            </select>
                        @endif
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
            <table id="simple-table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="center">@lang('form.status')</th>
                        <th class="center">@lang('form.username')</th>
                        <th class="center">@lang('form.name')</th>
                        <th class="center">@lang('form.role_name')</th>
                        <th class="center">@lang('form.email')</th>
                        <th class="center">@lang('form.phone')</th>
                        <th class="center">@lang('form.updated_at')</th>
                        <th class="center"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="center">
                                @if($user['status'] == 1)
                                    <span class="label label-sm label-success">@lang('form.enable')</span>
                                @else
                                    <span class="label label-sm label-danger">@lang('form.disable')</span>
                                @endif
                            </td>
                            <td class="center">{{ $user['username'] }}</td>
                            <td class="center">{{ $user['name'] }}</td>
                            <td class="center">{{ $user['role_name'] }}</td>
                            <td class="center">{{ $user['email'] }}</td>
                            <td class="center">{{ $user['phone'] }}</td>
                            <td class="center">{{ $user['updated_at'] }}</td>
                            <td>
                                <div class="hidden-sm hidden-xs btn-group">
                                    @if(in_array('update', $role_button))
                                        <a href="{{ route('users.edit', ['id' => $user['id']]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="bottom" title="@lang('form.edit')">
                                            <i class="ace-icon fa fa-pencil bigger-120"></i>
                                        </a>
                                    @endif
                                    @if(in_array('destroy', $role_button))
                                        <button type="button" onclick="deleteUser(this)" data-toggle="tooltip" data-placement="bottom" title="@lang('form.delete')" data-id="{{ $user['id'] }}" data-username="{{ $user['username'] }}" data-name="{{ $user['name'] }}" data-email="{{ $user['email'] }}" class="btn btn-xs btn-danger">
                                            <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
						</tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">@lang('form.no_data')</td>
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
    function deleteUser(button) {
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