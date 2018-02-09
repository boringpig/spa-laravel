<div class="form-group">
    <label for="parent_area" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> @lang('form.area') </label>
    <div class="col-xs-3">
        <h5>{{ $group['parent_area_name'] }}</h5>  
    </div>
</div>
<div class="space-4"></div>
<div class="form-group {{ $errors->has('child_area')? ' has-error' : '' }}">
    <label for="child_area[]" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> <span class="text-danger">*</span> @lang('form.group') </label>
    <div class="col-xs-4">
        <span class="block input-icon input-icon-right">
            <select multiple="" class="chosen-select form-control" id="child_area[]" name="child_area[]" data-placeholder="@lang('form.choose_one_area')">
                @forelse(getSCityArray() as $key => $value)
                    @if(!empty($group['child_area']) && in_array($key,$group['child_area']))
                        <option value="{{ $key }}" selected>{{ $value }}</option>
                    @else
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endif
                @empty
                @endforelse
            </select>
        </span>
    </div>
    @if($errors->has('child_area'))
        <div class="help-block col-xs-12 col-sm-reset inline">{{ $errors->first('child_area') }}</div>
    @endif
</div>
<div class="space-10"></div>
<div class="clearfix ">
    <div class="col-md-offset-3 col-md-9">
        <button type="submit" class="btn btn-white btn-info btn-bold">
            <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
            {{ $submit_button }}
        </button>
        <a href="{{ route('areagroups.index') }}" class="btn btn-white btn-grey btn-bold">
            <i class="ace-icon fa fa-undo bigger-110"></i>
            @lang('form.cancel_back')
        </a>
    </div>
</div>