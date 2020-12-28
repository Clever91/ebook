@php
use App\Models\Admin\Setting;
@endphp

<div class="form-group {{ $errors->has($field['name']) ? ' has-error' : '' }}">
    <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
    <input type="{{ $field['type'] }}"
       name="{{ $field['name'] }}"
       value="{{ old($field['name'], Setting::get($field['name'])) }}"
       class="form-control {{ Arr::get( $field, 'class') }}"
       id="{{ $field['name'] }}"
       placeholder="{{ $field['label'] }}">
    @if ($errors->has($field['name'])) <p>Small <code>{{ $errors->first($field['name']) }}</code></p> @endif
</div>