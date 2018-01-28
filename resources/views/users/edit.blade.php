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
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                @lang('form.edit')
            </small>
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-12">
            <form id="edit_form" class="form-horizontal" role="form" action="{{ route('users.update', ['id' => $user['id']]) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <input type="hidden" name="id" value="{{ $user['id'] }}">
                @include('users.partials.form', ['user' => $user, 'roles' => $roles, 'submit_button' => Lang::get('form.save_change')])
            </form>
        </div>
    </div>
    <div class="modal fade" id="changePasswordModal"  tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@lang('form.change_password')</h4>
                </div>
                <form class="form-horizontal" role="form" id="changePassword_form">
                    <div class="modal-body">
                        <input type="hidden" id="user_id" name="user_id" value="{{ $user['id'] }}">
                        <div class="form-group">
                            <label for="username" class="col-xs-offset-1 col-xs-2 control-label no-padding-right"><strong>@lang('form.username'):</strong></label>
                            <div class="col-xs-6">
                                <h4 style="margin-top:7px;">{{ $user['username'] }}</h4>
                            </div>
                        </div>
                        <div class="clearfix"></div>  
                        <div class="form-group">
                            <label for="password" class="col-xs-offset-1 col-xs-2 control-label no-padding-right"><strong> @lang('form.password'):</strong></label>
                            <div class="col-xs-6">
                                <input type="password" id="password" name="password" class="width-100">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="space-5"></div>
                        <div class="form-group">
                            <label for="password" class="col-xs-offset-1 col-xs-2 control-label no-padding-right"><strong> @lang('form.repeat_password'):</strong></label>
                            <div class="col-xs-6">
                                <input type="password" id="password-confirmation" name="password-confirmation" class="width-100">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="space-5"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white btn-grey btn-bold" data-dismiss="modal">
                            <i class="ace-icon fa fa-undo bigger-110"></i>@lang('form.back')
                        </button>
                        <button type="submit" class="btn btn-white btn-info btn-bold">
                            <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>@lang('form.change_password')
                        </button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('script')
<script>
    $('#status').click(function() {
        if($(this).prop('checked')) {
            $(this).val(1);
        } else {
            $(this).val(0);
        }
    });

    // 修改密码
    $('#changePassword_form').submit(function(event) {
        event.preventDefault();
        var id = $(this).find('input[name="user_id"]').val();
        var form_data = {
            'password': $(this).find('input[name="password"]').val(),
            'password_confirmation': $(this).find('input[name="password-confirmation"]').val(),
            '_token': "{{ csrf_token() }}",
        };
        $.ajax({
            type: 'POST',
            url: `/user-manage/users/change-password/${id}`,
            data: form_data,
            success: function (data, textStatus, jqXHR) {
                successMessage("@lang('message.change_password_success')");
                $('#changePasswordModal').modal('hide');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if(jqXHR.status == 422) {
                    var msg = '';
                    $.each(jqXHR.responseJSON.errors, function(key, value) {
                        msg += `<li>${value}</li>`;
                    });
                    errorMessage(msg);
                }else if(jqXHR.status == 500) {
                    errorMessage(jqXHR.responseJSON.errors);
                }
            }
        });
    })
</script>
@endsection
