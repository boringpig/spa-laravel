@extends('layouts.app')

@section('breadcrumb')
<li>
    <i class="ace-icon fa fa-book book-icon"></i>
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
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- form -->
            <form action="{{ route('articles.search') }}" method="get">
                <div class="row">
                    <div class="col-xs-3">
                        @lang('form.language')：
                        <select class="form-control" id="language" name="language">
                            <option value="">@lang('form.all')</option>
                            @foreach(getLanguageList() as $key => $value)
                                <option value="{{ $key }}" @if(old('language') == $key) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-3">
                        @lang('form.title')：
                        <input type="text" class="form-control" placeholder="@lang('form.title')" id="title" name="title" value="{{ old('title') }}">
                    </div>
                    <div class="col-xs-3">
                        @lang('form.updated_at')：
                        <div class="input-group">
                            <input id="updated_at" name="updated_at" type="text" class="form-control" placeholder="@lang('form.updated_at')" value="{{ old('updated_at') }}">
                            <span class="input-group-addon">
                                <i class="fa fa-clock-o bigger-110"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-xs-3" style="text-align:right;margin-top: 22px;">
                        @if(in_array('search', $role_button))
                            <button type="submit" class="btn btn-white btn-default btn-bold">
                                <i class="fa fa-fw fa-search"></i>@lang('form.search')
                            </button>
                        @endif
                        @if(in_array('store', $role_button))
                            <a href="{{ route('articles.create') }}" class="btn btn-white btn-success btn-bold">
                                <i class="fa fa-fw fa-plus"></i>@lang('form.create')</button>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
            <div class="space-10"></div>
            <!-- content -->
            <table id="simple-table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="center">@lang('form.language')</th>
                        <th class="center">@lang('form.title')</th>
                        <th class="center">@lang('form.updated_at')</th>
                        <th class="center"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($articles as $article)
                        <tr>
                            <td class="center">{{ $article['language_name'] }}</td>
                            <td class="center">{{ $article['title'] }}</td>
                            <td class="center">{{ $article['updated_at'] }}</td>
                            <td>
                                <div class="hidden-sm hidden-xs btn-group">
                                    @if(in_array('update', $role_button))
                                        <a href="{{ route('articles.edit', ['id' => $article['id']]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="bottom" title="@lang('form.edit')">
                                            <i class="ace-icon fa fa-pencil bigger-120"></i>
                                        </a>
                                    @endif
                                    @if(in_array('destroy', $role_button))
                                        <button type="button" onclick="deleteArticle(this)" data-toggle="tooltip" data-placement="bottom" title="@lang('form.delete')" data-id="{{ $article['id'] }}" data-language="{{ $article['language_name'] }}" data-title="{{ $article['title'] }}" class="btn btn-xs btn-danger">
                                            <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
						</tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">@lang('form.no_data')</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div><!-- /.col -->
    </div><!-- /.row -->
    @if($articles instanceof \Illuminate\Pagination\LengthAwarePaginator)
        @include('widgets.paginate', ['data' => $articles])
    @endif
@endsection

@section('script')
<script>
    $('#updated_at').datetimepicker({
        sideBySide: true,
        format: 'YYYY-MM-DD',
    });

	// 刪除使用者
    function deleteArticle(button) {
        var content = '';
        content += "<h4> @lang('form.title')：" + $(button).data('title')+ "</h4>";
        content += "<h4> @lang('form.language')：" + $(button).data('language')+ "</h4>";
        var id = $(button).data('id');
        var url = `/article-manage/articles/${id}`;
        var title = "@lang('message.are_you_sure_delete_article')";
        var redirect = "/article-manage/articles";
        var csrf_token = "{{ csrf_token() }}";
        deleteData(content,title,url,csrf_token,redirect)
	};
</script>
@endsection