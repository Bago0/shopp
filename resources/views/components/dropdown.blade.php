@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white'])

@php
    $alignmentClasses = match ($align) {
        'left' => 'dropdown-menu-start',
        'top' => '',
        default => 'dropdown-menu-end',
    };

    $widthClasses = match ($width) {
        '48' => 'w-48',
        default => $width,
    };
@endphp

<div class="dropdown" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div @click="open = ! open" class="dropdown-toggle" role="button" aria-expanded="open">
        {{ $trigger }}
    </div>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="dropdown-menu {{ $alignmentClasses }} {{ $widthClasses }} rounded shadow {{ $contentClasses }}"
         style="display: none;">
        <div class="rounded ring-1 ring-black ring-opacity-5">
            {{ $content }}
        </div>
    </div>
</div>
