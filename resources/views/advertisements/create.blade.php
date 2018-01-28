@extends('layouts.app')

@section('breadcrumb')
<li>
    <i class="ace-icon fa fa-users users-icon"></i>
    @lang('pageTitle.advertisement-manage')
</li>
<li>
    <a href="{{ route('advertisements.index') }}">@lang('pageTitle.advertisements_page')</a>
</li>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-timepicker.min.css') }}" />
@endsection

@section('content')
    <div class="page-header">
        <h1>
            @lang('pageTitle.advertisements_page')
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                @lang('form.create')
            </small>
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-10">
            <form id="create_form" class="form-horizontal" role="form" action="{{ route('advertisements.store') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                @include('advertisements.partials.form', ['submit_button' => Lang::get('form.submit_create')])
            </form>
        </div>
    </div>
@endsection

@section('script')
<script src="{{ asset('assets/js/bootstrap-timepicker.min.js') }}"></script>
<script>
    $(function() {
        $('#path').ace_file_input({
            style:'well',
            btn_choose:'上传图片/影音',
            btn_change:null,
            no_icon:'ace-icon fa fa-picture-o',
            thumbnail:'large',
            droppable:true,
        })

        $('#publish_at').datetimepicker({
            sideBySide: true,
            format: 'YYYY-MM-DD',
        });

        $('input[id="broadcast_time"]').timepicker({
            minuteStep: 1,
            showMeridian: false,
            disableFocus: true,
            defaultTime: false,
            icons: {
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down'
            }
        });
        
        $('#status').click(function() {
            if($(this).prop('checked')) {
                $(this).val(1);
            } else {
                $(this).val(0);
            }
        });
    });
</script>
@endsection