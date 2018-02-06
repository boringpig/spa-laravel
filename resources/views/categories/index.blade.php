@extends('layouts.app')

@section('breadcrumb')
<li>
    <i class="ace-icon fa fa-book book-icon"></i>
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
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12" style="text-align:right;margin-top: 22px;">
                    @if(in_array('store', $role_button))
                        <a href="{{ route('categories.create') }}" class="btn btn-white btn-success btn-bold">
                            <i class="fa fa-fw fa-plus"></i>@lang('form.create')</button>
                        </a>
                    @endif
                </div>
            </div>
            <div class="space-10"></div>
            <!-- content -->
            <table id="simple-table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="center">@lang('form.title_no')</th>
                        <th class="center">@lang('form.title_name')</th>
                        <th class="center">@lang('form.updated_at')</th>
                        <th class="center"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td class="center">{{ $category['no'] }}</td>
                            <td class="center">{{ $category['name'] }}</td>
                            <td class="center">{{ $category['updated_at'] }}</td>
                            <td>
                                <div class="action-buttons">
                                    @if(in_array('update', $role_button))
                                        <a href="{{ route('categories.edit', ['id' => $category['id']]) }}" class="blue" data-toggle="tooltip" data-placement="bottom" title="@lang('form.edit')">
                                            <i class="ace-icon fa fa-pencil bigger-120"></i>
                                        </a>
                                    @endif
                                    @if(in_array('destroy', $role_button))
                                        <a href="" class="red" onclick="deleteCategory(event,this)" data-toggle="tooltip" data-placement="bottom" title="@lang('form.delete')" data-id="{{ $category['id'] }}" data-no="{{ $category['no'] }}" data-name="{{ $category['name'] }}">
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
    @if($categories instanceof \Illuminate\Pagination\LengthAwarePaginator)
        @include('widgets.paginate', ['data' => $categories])
    @endif
@endsection

@section('script')
<script>
    $('#updated_at').datetimepicker({
        sideBySide: true,
        format: 'YYYY-MM-DD',
    });

	// 刪除使用者
    function deleteCategory(event,button) {
        event.preventDefault();
        var content = '';
        content += "<h4> @lang('form.title_no')：" + $(button).data('no')+ "</h4>";
        content += "<h4> @lang('form.title_name')：" + $(button).data('name')+ "</h4>";
        var id = $(button).data('id');
        var url = `/article-manage/categories/${id}`;
        var title = "@lang('message.are_you_sure_delete_category')";
        var redirect = "/article-manage/categories";
        var csrf_token = "{{ csrf_token() }}";
        deleteData(content,title,url,csrf_token,redirect)
	};
</script>
@endsection