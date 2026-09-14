<button {{ $attributes->merge(['type' => 'button', 'class' => 'action-quiet disabled:opacity-40']) }}>
    {{ $slot }}
</button>
