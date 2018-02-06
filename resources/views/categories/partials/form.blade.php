<div class="form-group {{ $errors->has('no')? ' has-error' : '' }}">
    <label for="no" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> <span class="text-danger">*</span> @lang('form.title_no') </label>
    <div class="col-xs-3">
        <span class="block input-icon input-icon-right">
            <input type="number" id="no" name="no" class="width-100" min="0" value="{{ !empty($category['no'])? $category['no'] : old('no') }}">
            @if($errors->has('no'))
                <i class="ace-icon fa fa-times-circle"></i>
            @endif
        </span>
    </div>
    @if($errors->has('no'))
        <div class="help-block col-xs-12 col-sm-reset inline">{{ $errors->first('no') }}</div>
    @endif
</div>
<div class="space-4"></div>
<div class="form-group {{ $errors->has('name')? ' has-error' : '' }}">
    <label for="name" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> <span class="text-danger">*</span> @lang('form.title_name') </label>
    <div class="col-xs-3">
        <span class="block input-icon input-icon-right">
            <input type="text" id="name" name="name" class="width-100" value="{{ !empty($category['name'])? $category['name'] : old('name') }}">
            @if($errors->has('name'))
                <i class="ace-icon fa fa-times-circle"></i>
            @endif
        </span>
    </div>
    @if($errors->has('name'))
        <div class="help-block col-xs-12 col-sm-reset inline">{{ $errors->first('name') }}</div>
    @endif
</div>
<div class="space-10"></div>
<div class="clearfix ">
    <div class="col-md-offset-3 col-md-9">
        <button type="submit" class="btn btn-white btn-info btn-bold">
            <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
            {{ $submit_button }}
        </button>
        <a href="{{ route('articles.index') }}" class="btn btn-white btn-grey btn-bold">
            <i class="ace-icon fa fa-undo bigger-110"></i>
            @lang('form.cancel_back')
        </a>
    </div>
</div>