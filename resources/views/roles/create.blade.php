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
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                @lang('form.create')
            </small>
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-10">
            <form id="create_form" class="form-horizontal" role="form" action="{{ route('roles.store') }}" method="post">
                {{ csrf_field() }}
                @include('roles.partials.form', ['submit_button' => Lang::get('form.submit_create'),'data' => $data, 'menu_list' => $menu_list, 'button_list' => $button_list])
            </form>
        </div>
    </div>
@endsection

@section('script')
<script src="{{ asset('web/js/roles.js') }}"></script>
<script>
    $(function() {
        selectAllUsers();
        selectAllRoles();
        selectAllArticles();
        selectAllAdvertisements();
        selectAllKiosks();
    });
</script>
@endsection