@extends('layouts.app')

@section('breadcrumb')
<li>
    <i class="ace-icon fa fa-users users-icon"></i>
    @lang('pageTitle.users_manage')
</li>
<li>
    <a href="{{ route('users') }}">@lang('pageTitle.users_page')</a>
</li>
@endsection

@section('content')
    <div class="page-header">
        <h1>
            @lang('pageTitle.users_page')
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                @lang('form.create')
            </small>
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-12">
            <form id="create_form" class="form-horizontal" role="form" method="post">
                @include('users.partials.form')
            </form>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(function() {
        $('#create_form').submit(function(event) {
            event.preventDefault();
            form_data = {
                'username': $('#username').val(),
                'password': $('#password').val(),
                'name': $('#name').val(),
                'email': $('#email').val(),
                'phone': $('#phone').val(),
                'status': $('#status').val(),
                '_token': "{{ csrf_token() }}",
            };
            $.ajax({
                type:'POST',
                url:'/api/users',
                data: form_data,
                success: function (data, textStatus, jqXHR) {
                    if(jqXHR.status == 200) {
                        var title = "@lang('form.created_success')";
                        var sure_button = "@lang('form.sure')";
                        var cancel_button = "@lang('form.cancel')";
                        var redirectUrl = "/user-manage/users";
                        showSuccessDialog(title,sure_button,cancel_button,redirectUrl);
                    }
                },
                error:  function (jqXHR, textStatus, errorThrown) {
                    //資料驗證失敗
			        if(jqXHR.status == 422) {
                        var errors = jqXHR.responseJSON.errors;
                        var msg = '';
                        $.each(errors, function(key,val) {
                            msg += '<li><strong class="text-danger">' + val + '</strong></li>';
                        });
                        var title = "@lang('form.column_validation_error')";
                        var sure_button = "@lang('form.sure')";
                        showErrorDialog(msg,title,sure_button);
                    }
                }
            });
        });
    });
</script>
@endsection