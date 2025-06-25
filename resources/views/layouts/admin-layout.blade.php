<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-tr from-sky-950 to-sky-900 text-white min-h-screen">

    <div class="flex min-h-screen">
        {{-- Sidebar (akan menutupi sampai bawah) --}}
        @include('layouts.admin-navigation')

        {{-- Konten utama --}}
        <div class="flex-1 flex flex-col">
            <main class="flex-1 p-6 overflow-y-auto">
                @isset($header)
                    <div class="mb-6 border-b border-white/10 pb-4">
                        {{ $header }}
                    </div>
                @endisset

                <div>
                    {{ $slot }}
                </div>
            </main>

            {{-- Footer biasa, akan berada di bawah jika scroll --}}
            <footer class="text-center py-4">
                <p class="text-sm text-gray-300 tracking-wide">
                    &copy; {{ date('Y') }} Kementerian Dalam Negeri. All rights reserved.
                </p>
            </footer>
        </div>
    </div>

</body>
</html>
