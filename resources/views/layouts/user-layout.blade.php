<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Kemendagri - Kota Malang</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/logokemendagri-fix.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('scripts')
</head>

<body class="bg-gradient-to-tr from-sky-950 to-sky-900 text-white min-h-screen flex flex-col">

    {{-- Navbar --}}
    @include('layouts.user-navigation')

    {{-- Main Content --}}
    <main class="flex-1 p-6">
        @isset($header)
            <div class="mb-6 border-b border-white/10 pb-4">
                {{ $header }}
            </div>
        @endisset

        <div>
            {{ $slot }}
        </div>
    </main>

    {{-- Footer --}}
    <footer class="text-center text-sm text-white py-6 border-t border-white/10 mt-auto">
        &copy; {{ now()->year }} Kementerian Dalam Negeri — Kota Malang. All rights reserved.
    </footer>

    {{-- JS Wilayah Modular --}}
    <script>
        const fetchWilayah = (id, endpoint, targetId, label) => {
            fetch(`/wilayah/${endpoint}/${id}`)
                .then(res => res.json())
                .then(data => {
                    const target = document.getElementById(targetId);
                    target.innerHTML = `<option value="">-- Pilih ${label} --</option>`;
                    data.forEach(item => {
                        target.innerHTML += `<option value="${item.id}">${item.nama}</option>`;
                    });
                });
        };

        document.getElementById('provinsi_id')?.addEventListener('change', function () {
            fetchWilayah(this.value, 'kabupaten', 'kabupaten_id', 'Kabupaten/Kota');
        });

        document.getElementById('kabupaten_id')?.addEventListener('change', function () {
            fetchWilayah(this.value, 'kecamatan', 'kecamatan_id', 'Kecamatan');
        });

        document.getElementById('kecamatan_id')?.addEventListener('change', function () {
            fetchWilayah(this.value, 'kelurahan', 'kelurahan_id', 'Kelurahan');
        });
    </script>
</body>
</html>
