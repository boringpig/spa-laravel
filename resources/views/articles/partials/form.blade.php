<div class="form-group {{ $errors->has('title')? ' has-error' : '' }}">
    <label for="title" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> <span class="text-danger">*</span> @lang('form.title') </label>
    <div class="col-xs-3">
        <span class="block input-icon input-icon-right">
            <input type="text" id="title" name="title" class="width-100" value="{{ !empty($article['title'])? $article['title'] : old('title') }}">
            @if($errors->has('title'))
                <i class="ace-icon fa fa-times-circle"></i>
            @endif
        </span>
    </div>
    @if($errors->has('title'))
        <div class="help-block col-xs-12 col-sm-reset inline">{{ $errors->first('title') }}</div>
    @endif
</div>
<div class="space-4"></div>
<div class="form-group {{ $errors->has('language')? ' has-error' : '' }}">
    <label for="language" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> <span class="text-danger">*</span> @lang('form.language') </label>
    <div class="col-xs-3">
        <span class="block input-icon input-icon-right">
            <select class="chosen-select width-100" id="language" name="language" data-placeholder="@lang('form.choose_one_language')">
                <option value="">  </option>
                @foreach(getLanguageList() as $key => $value)
                    @if(!empty($article['language']) && $key == $article['language'])
                        <option value="{{ $key }}" selected>{{ $value }}</option>
                    @else
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endif
                @endforeach
            </select>
            @if($errors->has('language'))
                <i class="ace-icon fa fa-times-circle"></i>
            @endif
        </span>
    </div>
    @if($errors->has('language'))
        <div class="help-block col-xs-12 col-sm-reset inline">{{ $errors->first('language') }}</div>
    @endif
</div>
<div class="space-4"></div>
<div class="form-group {{ $errors->has('broadcast_area')? ' has-error' : '' }}">
    <label for="broadcast_area[]" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> <span class="text-danger">*</span> @lang('form.broadcast_area') </label>
    <div class="col-xs-4">
        <span class="block input-icon input-icon-right">
            <select multiple="" class="chosen-select form-control" id="broadcast_area[]" name="broadcast_area[]" data-placeholder="@lang('form.choose_one_area')">
                @forelse(getSCityArray() as $key => $value)
                    @if(!empty($article['broadcast_area']) && in_array($key,$article['broadcast_area']))
                        <option value="{{ $key }}" selected>{{ $value }}</option>
                    @else
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endif
                @empty
                @endforelse
            </select>
        </span>
    </div>
    @if($errors->has('broadcast_area'))
        <div class="help-block col-xs-12 col-sm-reset inline">{{ $errors->first('broadcast_area') }}</div>
    @endif
</div>
<div class="space-4"></div>
<div class="form-group {{ $errors->has('content')? ' has-error' : '' }}">
    <label for="content" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> <span class="text-danger">*</span> @lang('form.content') </label>
    <div class="col-sm-9">
        <span class="block input-icon input-icon-right">
            <textarea name="content" id="content" cols="30" rows="10">{{ !empty($article['content'])? $article['content'] : old('content') }}</textarea>
            @if($errors->has('content'))
                <i class="ace-icon fa fa-times-circle"></i>
            @endif
        </span>
    </div>
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