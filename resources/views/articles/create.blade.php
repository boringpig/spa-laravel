@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('summernote/summernote.css') }}" />
@endsection

@section('breadcrumb')
<li>
    <i class="ace-icon fa fa-book"></i>
    @lang('pageTitle.article-manage')
</li>
<li>
    <a href="{{ route('articles.index') }}">@lang('pageTitle.articles_page')</a>
</li>
@endsection

@section('content')
    <div class="page-header">
        <h1>
            @lang('pageTitle.articles_page')
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                @lang('form.create')
            </small>
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-10">
            <form id="create_form" class="form-horizontal" role="form" action="{{ route('articles.store') }}" method="post">
                {{ csrf_field() }}
                @include('articles.partials.form', ['submit_button' => Lang::get('form.submit_create')])
            </form>
        </div>
    </div>
@endsection

@section('script')
<script src="{{ asset('summernote/summernote.min.js') }}"></script>
<script src="{{ asset('summernote/lang/summernote-zh-CN.js') }}"></script>
<script>
    $(function() {
        $('#content').summernote({
            height: 300,
            lang: 'zh-CN',
            focus: true,
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['fontname', ['fontname']],
                ['font', ['fontsize','color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['table','picture']],
                ['codeview', ['codeview']],
            ]
        });
    });
</script>
@endsection