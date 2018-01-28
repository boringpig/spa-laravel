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
                @lang('form.create')
            </small>
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-12">
            <form id="create_form" class="form-horizontal" role="form" action="{{ route('users.store') }}" method="post">
                {{ csrf_field() }}
                @include('users.partials.form', ['roles' => $roles, 'submit_button' => Lang::get('form.submit_create')])
            </form>
        </div>
    </div>
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
</script>
@endsection
