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
                @lang('form.edit')
            </small>
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-10">
            <form id="edit_form" class="form-horizontal" role="form" action="{{ route('advertisements.update', ['id' => $advertisement['id']]) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <input type="hidden" name="id" value="{{ $advertisement['id'] }}">
                @include('advertisements.partials.form', ['advertisement' => $advertisement,'submit_button' => Lang::get('form.save_change')])
            </form>
        </div>
    </div>
    <div class="modal fade" id="changeFileModal"  tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@lang('form.change_image_or_video')</h4>
                </div>
                <form class="form-horizontal" role="form" id="changeFile_form" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" id="advertisement_id" name="advertisement_id" value="{{ $advertisement['id'] }}">
                        <div class="form-group">
                            <label for="" class="col-xs-offset-1 col-xs-2 control-label no-padding-right">
                                <strong>@lang('form.advertisement_name'):</strong>
                            </label>
                            <div class="col-xs-6">
                                <h4 style="margin-top:7px;">{{ $advertisement['name'] }}</h4>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-xs-3 control-label no-padding-right"><strong>@lang('form.old_image_or_video'):</strong></label>
                            <div class="col-xs-6">
                                <img src="{{ $advertisement['path'] }}" alt="{{ $advertisement['name'] }}" width="200" height="180">
                            </div>
                        </div>
                        <div class="clearfix"></div>  
                        <div class="form-group">
                            <label for="advertisement_path" class="col-xs-3 control-label no-padding-right"><strong> @lang('form.new_image_or_video'):</strong></label>
                            <div class="col-xs-6">
                                <input type="file" id="advertisement_path" name="advertisement_path" class="width-100">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="space-5"></div>
                    </div>
                    <div class="space-5"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white btn-grey btn-bold" data-dismiss="modal">
                            <i class="ace-icon fa fa-undo bigger-110"></i>@lang('form.back')
                        </button>
                        <button type="submit" class="btn btn-white btn-info btn-bold">
                            <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>@lang('form.change_image_or_video')
                        </button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('script')
<script src="{{ asset('assets/js/bootstrap-timepicker.min.js') }}"></script>
<script>
    $(function() {
        $('#advertisement_path').ace_file_input({
            style:'well',
            btn_choose:'上传图片/影音',
            btn_change:null,
            no_icon:'ace-icon fa fa-picture-o',
            thumbnail:'large',
            droppable:true,
        });

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

        // 修改圖片/影音
        $('#changeFile_form').submit(function(event) {
            event.preventDefault();
            var id = $(this).find('input[name="advertisement_id"]').val();
            var form_data = new FormData();
            form_data.append('_token', "{{ csrf_token() }}");
            form_data.append('path', $(this).find('input[type="file"]')[0].files[0]);
            $.ajax({
                type: 'POST',
                url: `/advertisement-manage/advertisements/change-file/${id}`,
                data: form_data,
                contentType: false,
                processData: false,
                success: function (data, textStatus, jqXHR) {
                    successMessage("@lang('message.change_image_or_video_success')");
                    $('#changeFileModal').modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    if(jqXHR.status == 422) {
                        var msg = '';
                        $.each(jqXHR.responseJSON.errors, function(key, value) {
                            msg += `<li>${value}</li>`;
                        });
                        errorMessage(msg);
                    }else if(jqXHR.status == 500) {
                        errorMessage(jqXHR.responseJSON.errors);
                    }
                }
            });
        })
    });
</script>
@endsection