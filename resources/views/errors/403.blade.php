@extends('layouts.app')

@section('breadcrumb')
<li>
    <i class="ace-icon fa fa-home home-icon"></i>
    <a href="{{ route('home') }}">@lang('pageTitle.dashboard')</a>
</li>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="error-container">
            <div class="well">
                <h1 class="grey lighter smaller">
                    <span class="blue bigger-125">
                        <i class="ace-icon fa fa-sitemap"></i>
                        403
                    </span>
                    @lang('message.the_page_is_forbidden_to_enter')
                </h1>

                <hr />
                <h3 class="lighter smaller">@lang('message.the_account_no_authority')!</h3>

                <hr />
                <div class="space"></div>

                <div class="center">
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="ace-icon fa fa-tachometer"></i>
                        @lang('pageTitle.dashboard')
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection