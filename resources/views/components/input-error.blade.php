@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-muted small list-unstyled mb-0']) }}>
        @foreach ((array) $messages as $message)
            <li class="text-danger">{{ $message }}</li>
        @endforeach
    </ul>
@endif
