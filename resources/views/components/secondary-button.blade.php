<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-light text-uppercase fw-semibold text-xs shadow-sm']) }}>
    {{ $slot }}
</button>
