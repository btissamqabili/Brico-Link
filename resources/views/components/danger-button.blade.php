<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center rounded-sm border border-[#7F2020] px-4 py-3 text-sm font-bold text-[#7F2020] transition hover:bg-[#f8e9e7]']) }}>
    {{ $slot }}
</button>
