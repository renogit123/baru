<!DOCTYPE html>
@stack('scripts')
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
<body class="bg-gradient-to-tr from-sky-950 to-sky-900 text-white min-h-screen flex flex-col">
<script>
    document.getElementById('provinsi_id').addEventListener('change', function () {
        fetch('/wilayah/kabupaten/' + this.value)
            .then(res => res.json())
            .then(data => {
                const kabupatenSelect = document.getElementById('kabupaten_id');
                kabupatenSelect.innerHTML = '<option value="">-- ' + this.options[this.selectedIndex].text + ' --</option>';
                data.forEach(item => {
                    kabupatenSelect.innerHTML += `<option value="${item.id}">${item.nama}</option>`;
                });
            });
    });

    document.getElementById('kabupaten_id').addEventListener('change', function () {
        fetch('/wilayah/kecamatan/' + this.value)
            .then(res => res.json())
            .then(data => {
                const kecamatanSelect = document.getElementById('kecamatan_id');
                kecamatanSelect.innerHTML = '<option value="">-- Provinsi ' + this.options[this.selectedIndex].text + ' --</option>';
                data.forEach(item => {
                    kecamatanSelect.innerHTML += `<option value="${item.id}">${item.nama}</option>`;
                });
            });
    });

    document.getElementById('kecamatan_id').addEventListener('change', function () {
        fetch('/wilayah/kelurahan/' + this.value)
            .then(res => res.json())
            .then(data => {
                const kelurahanSelect = document.getElementById('kelurahan_id');
                kelurahanSelect.innerHTML = '<option value="">-- Kecamatan ' + this.options[this.selectedIndex].text + ' --</option>';
                data.forEach(item => {
                    kelurahanSelect.innerHTML += `<option value="${item.id}">${item.nama}</option>`;
                });
            });
    });
</script>
    @include('layouts.user-navigation')

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

    <footer class="text-center text-sm text-white py-4">
        &copy; {{ now()->year }} Kementerian Dalam Negeri - User Panel
    </footer>
</body>
</html>
