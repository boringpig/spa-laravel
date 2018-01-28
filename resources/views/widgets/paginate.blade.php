<div class="row">
    <div class="col-xs-7">
        <div style="text-align:right">
            {{ $data->render() }}
        </div>
    </div>
    <div class="col-xs-5">
        <div style="text-align:right;margin-top:23px;">
            @lang('form.total_count')：{{ $data->total() }} @lang('form.number')，@lang('form.sum') {{ $data->lastPage() }} @lang('form.page')
        </div>
    </div>
</div>