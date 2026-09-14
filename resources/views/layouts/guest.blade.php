<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Bricofy</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="min-h-screen bg-[#f6f3eb] px-5 py-10 sm:flex sm:flex-col sm:items-center sm:justify-center">
            <div>
                <a href="/">
                    <span aria-label="Bricofy" class="flex items-center gap-3 font-serif text-3xl font-bold tracking-[-0.04em] text-[#7F2020]"><span aria-hidden="true" class="flex h-10 w-10 items-center justify-center rounded-sm bg-[#7F2020] text-xl text-[#F6F3EB]">⚒</span>Bricofy<span class="text-[#869B7E]">.</span></span>
                </a>
            </div>

            <div class="mt-8 w-full overflow-hidden border border-[#e5dfd4] bg-white px-6 py-7 shadow-[0_10px_30px_rgba(47,41,38,0.045)] sm:max-w-md sm:px-8">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
