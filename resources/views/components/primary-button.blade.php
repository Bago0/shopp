<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-dark text-uppercase fw-semibold btn-sm']) }}>
    {{ $slot }}
</button>
