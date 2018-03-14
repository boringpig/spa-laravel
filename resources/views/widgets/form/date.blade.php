{{ $title }}：
<div class="input-group">
    <input id="updated_at" name="updated_at" type="text" class="form-control" placeholder="{{ $title }}" value="{{ old('updated_at') }}">
    <span class="input-group-addon">
        <i class="fa fa-clock-o bigger-110"></i>
    </span>
</div>