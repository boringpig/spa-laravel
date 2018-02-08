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
                @lang('form.edit')
            </small>
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-10">
            <form id="edit_form" class="form-horizontal" role="form" action="{{ route('categories.update', ['id' => $category['id']]) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <input type="hidden" name="id" value="{{ $category['id'] }}">
                @include('categories.partials.form', ['category' => $category,'submit_button' => Lang::get('form.save_change')])
            </form>
        </div>
    </div>
@endsection