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
                @lang('form.edit')
            </small>
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-10">
            <form id="edit_form" class="form-horizontal" role="form" action="{{ route('areagroups.update', ['id' => $group['id']]) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <input type="hidden" name="id" value="{{ $group['id'] }}">
                @include('areagroups.partials.form', ['group' => $group,'submit_button' => Lang::get('form.save_change')])
            </form>
        </div>
    </div>
@endsection