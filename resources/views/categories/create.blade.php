@extends('layouts.app')

@section('breadcrumb')
<li>
    <i class="ace-icon fa fa-book"></i>
    @lang('pageTitle.article-manage')
</li>
<li>
    <a href="{{ route('categories.index') }}">@lang('pageTitle.categories_page')</a>
</li>
@endsection

@section('content')
    <div class="page-header">
        <h1>
            @lang('pageTitle.categories_page')
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                @lang('form.create')
            </small>
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-10">
            <form id="create_form" class="form-horizontal" role="form" action="{{ route('categories.store') }}" method="post">
                {{ csrf_field() }}
                @include('categories.partials.form', ['submit_button' => Lang::get('form.submit_create')])
            </form>
        </div>
    </div>
@endsection