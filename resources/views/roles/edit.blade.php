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
                @lang('form.edit')
            </small>
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-10">
            <form id="edit_form" class="form-horizontal" role="form" action="{{ route('roles.update', ['id' => $role['id']]) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <input type="hidden" name="id" value="{{ $role['id'] }}">
                @include('roles.partials.form', ['role' => $role, 'submit_button' => Lang::get('form.save_change'),'data' => $data])
            </form>
        </div>
    </div>
@endsection

@section('script')
<script src="{{ asset('web/js/roles.js') }}"></script>
<script>
    $(function() {
        selectAllResource();
    });
</script>
@endsection