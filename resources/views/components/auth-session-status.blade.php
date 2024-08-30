@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'fw-medium text-success small']) }}>
        {{ $status }}
    </div>
@endif
