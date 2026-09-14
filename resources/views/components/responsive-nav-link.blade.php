@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full border-l-4 border-[#7F2020] bg-[#f6f3eb] px-4 py-3 text-start text-base font-semibold text-[#7F2020] transition'
            : 'block w-full border-l-4 border-transparent px-4 py-3 text-start text-base font-semibold text-[#6F6862] transition hover:bg-[#f6f3eb] hover:text-[#7F2020]';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
