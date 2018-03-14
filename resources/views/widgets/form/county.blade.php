@lang('form.county')：
<select class="chosen-select width-100" id="county" name="county">
    <option value="">@lang('form.all')</option>
    @forelse($counties as $key => $value)
        <option value="{{ $key }}" @if($key == old('county')) selected @endif>{{ $value }}</option>
    @empty
    @endforelse
</select>