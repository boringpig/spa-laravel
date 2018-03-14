@lang('form.area')：
<select class="chosen-select width-100" id="area" name="area">
    <option value="">@lang('form.all')</option>
    @forelse($areas as $key => $value)
        <option value="{{ $key }}" @if($key == old('area')) selected @endif>{{ $value }}</option>
    @empty
    @endforelse
</select>