{{-- Global configuration object --}}
@php
$config = [
    'appName' => config('app.name'),
    'locale' => $locale = app()->getLocale(),
    'translations' => json_decode(file_get_contents(resource_path("lang/{$locale}.json")), true),
];
@endphp
<script>window.config = {!! json_encode($config); !!};</script>

{{-- Polyfill some features via polyfill.io --}}
@php
$polyfills = [
    'Promise',
    'Object.assign',
    'Object.values',
    'Array.prototype.find',
    'Array.prototype.findIndex',
    'Array.prototype.includes',
    'String.prototype.includes',
    'String.prototype.startsWith',
    'String.prototype.endsWith',
];
@endphp
<script src="https://cdn.polyfill.io/v2/polyfill.min.js?features={{ implode(',', $polyfills) }}"></script>

<script src="{{ mix('js/app.js') }}"></script>
