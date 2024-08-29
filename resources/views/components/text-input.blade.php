@props(['disabled' => false])

<input
    type="text"
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge([
        'class' => 'form-control border-gray-300 rounded shadow-sm',
        'style' => 'border-color: ' . ($disabled ? '#e9ecef' : '#ced4da') . '; box-shadow: ' . ($disabled ? 'none' : '0 0 0 .2rem rgba(0,123,255,.25)') . ';'
    ]) !!}
>
