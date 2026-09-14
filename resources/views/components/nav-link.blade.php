@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center border-b-2 border-[#7F2020] px-3 py-3 text-sm font-semibold text-[#7F2020] transition'
            : 'inline-flex items-center border-b-2 border-transparent px-3 py-3 text-sm font-semibold text-[#6F6862] transition hover:border-[#e5dfd4] hover:text-[#7F2020]';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
