@php
use App\Models\Admin\Setting;
@endphp

<div class="form-group {{ $errors->has($field['name']) ? ' has-error' : '' }}">
    <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
    <textarea name="{{ $field['name'] }}"
       class="form-control {{ Arr::get( $field, 'class') }}"
       id="{{ $field['name'] }}">{{ old($field['value'], Setting::get($field['name'])) }}</textarea>
    @if ($errors->has($field['name'])) <p>Small <code>{{ $errors->first($field['name']) }}</code></p> @endif
</div>
