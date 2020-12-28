@php
use App\Models\Admin\Setting;
@endphp

<div class="icheck-primary {{ $errors->has($field['name']) ? ' has-error' : '' }}">
    <input type="{{ $field['type'] }}" name="{{ $field['name'] }}"
        @if (old($field['name'], Setting::get($field['name'])) == "on") checked @endif  data-bootstrap-switch
        class="{{ Arr::get( $field, 'class') }}" id="{{ $field['name'] }}">
    <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
    @if ($errors->has($field['name'])) <p>Small <code>{{ $errors->first($field['name']) }}</code></p> @endif
</div>

