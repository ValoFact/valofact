@php
$name ??= '';

@endphp


@error($name)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror