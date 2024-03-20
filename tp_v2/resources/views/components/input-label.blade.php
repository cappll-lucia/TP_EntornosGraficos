@props(['value'])

<label class="form-label {{ $attributes->get('class') }}">
    {{ $value ?? $slot }}
</label>
