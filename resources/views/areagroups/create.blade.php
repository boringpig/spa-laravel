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
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                @lang('form.create')
            </small>
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-10">
            <form id="create_form" class="form-horizontal" role="form" action="{{ route('areagroups.store') }}" method="post">
                {{ csrf_field() }}
                @include('areagroups.partials.form', ['submit_button' => Lang::get('form.submit_create')])
            </form>
        </div>
    </div>
@endsection