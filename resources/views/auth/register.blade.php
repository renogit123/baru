<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Kemendagri</title>
    <link rel="icon" href="{{ asset('img/logokemendagri-fix.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, #0a1f44, #1e40af);
        }

        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card-gradient {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen px-4 text-white">

    <a href="{{ url('/') }}" class="absolute top-6 left-6 text-white text-sm font-semibold flex items-center hover:underline">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali ke Beranda
    </a>

    <div class="w-full max-w-3xl p-8 rounded-2xl shadow-xl fade-in card-gradient">
        <div class="text-center mb-6">
            <img src="{{ asset('img/logokemendagri-fix.png') }}" alt="Logo Kemendagri" class="mx-auto w-16 mb-3 drop-shadow-md">
            <h2 class="text-2xl font-bold">Pendaftaran Pengguna</h2>
            <p class="text-sm text-white/90">Silakan isi formulir untuk membuat akun Anda</p>
        </div>

        <form id="registerForm" method="POST" action="{{ route('register') }}" novalidate>

    @csrf

    {{-- Nama --}}
    <x-input-label for="name" value="Nama Lengkap" class="text-white" />
    <x-text-input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
        class="w-full mb-1 bg-white/90 text-gray-900" />
    @error('name') <p class="text-sm text-red-400 mb-3">{{ $message }}</p> @enderror

    {{-- Email --}}
    <x-input-label for="email" value="Email" class="text-white" />
    <x-text-input id="email" name="email" type="email" value="{{ old('email') }}" required
        class="w-full mb-1 bg-white/90 text-gray-900" />
    @error('email') <p class="text-sm text-red-400 mb-3">{{ $message }}</p> @enderror

    {{-- Kata Sandi --}}
    <x-input-label for="password" value="Kata Sandi" class="text-white" />
    <x-text-input id="password" name="password" type="password" required
        class="w-full mb-1 bg-white/90 text-gray-900" />
    @error('password') <p class="text-sm text-red-400 mb-3">{{ $message }}</p> @enderror

    {{-- Konfirmasi Sandi --}}
    <x-input-label for="password_confirmation" value="Konfirmasi Kata Sandi" class="text-white" />
    <x-text-input id="password_confirmation" name="password_confirmation" type="password" required
        class="w-full mb-4 bg-white/90 text-gray-900" />

    {{-- Biodata --}}
    <x-input-label for="nama" value="Nama Peserta" class="text-white" />
    <x-text-input id="nama" name="nama" type="text" value="{{ old('nama') }}" class="w-full mb-1 bg-sky-900 text-white" />
    @error('nama') <p class="text-sm text-red-400 mb-3">{{ $message }}</p> @enderror

    <x-input-label for="alamat" value="Alamat" class="text-white" />
    <textarea id="alamat" name="alamat" class="w-full mb-1 bg-sky-900 text-white rounded">{{ old('alamat') }}</textarea>
    @error('alamat') <p class="text-sm text-red-400 mb-3">{{ $message }}</p> @enderror

    {{-- Desa/Kelurahan (Autocomplete + Hidden ID) --}}
    <input type="hidden" name="id_desa" id="id_desa" value="{{ old('id_desa') }}">
    @error('id_desa') <p class="text-sm text-red-400 mb-3">{{ $message }}</p> @enderror

    {{-- Wilayah Otomatis --}}
    @foreach (['provinsi', 'kabupaten', 'kecamatan', 'desa', 'kode_desa'] as $field)
        <x-input-label for="{{ $field }}" value="{{ ucwords(str_replace('_', ' ', $field)) }}" class="text-white mt-2" />
        <x-text-input id="{{ $field }}" name="{{ $field }}" readonly
            class="w-full mb-1 bg-sky-800 border border-yellow-400/20 text-white" value="{{ old($field) }}" />
    @endforeach

    {{-- Input Lainnya --}}
    @php
        $fields = [
            'nik' => 'NIK', 'npwp' => 'NPWP (opsional)', 'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir', 'jabatan' => 'Jabatan',
            'lama_menjabat' => 'Lama Menjabat (tahun)', 'nomor_sk_jabatan' => 'Nomor SK Jabatan',
            'no_telp' => 'No Telepon'
        ];
    @endphp
    @foreach($fields as $key => $label)
        <x-input-label for="{{ $key }}" value="{{ $label }}" class="text-white mt-2" />
        <x-text-input id="{{ $key }}" name="{{ $key }}" type="{{ $key === 'tanggal_lahir' ? 'date' : ($key === 'lama_menjabat' ? 'number' : 'text') }}"
            class="w-full mb-1 bg-sky-900 text-white" value="{{ old($key) }}" />
        @error($key) <p class="text-sm text-red-400 mb-3">{{ $message }}</p> @enderror
    @endforeach

    {{-- Dropdown --}}
    @php
        $dropdowns = [
            'jenis_kelamin' => ['Laki-laki', 'Perempuan'],
            'agama' => ['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu','Lainnya'],
            'status_kawin' => ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'],
            'pendidikan' => ['SD','SMP','SMA','Diploma','Sarjana','Magister','Doktor','Lainnya']
        ];
    @endphp
    @foreach ($dropdowns as $name => $options)
        <x-input-label for="{{ $name }}" value="{{ ucwords(str_replace('_', ' ', $name)) }}" class="text-white mt-2" />
        <select id="{{ $name }}" name="{{ $name }}"
            class="w-full mb-1 bg-sky-900 text-white border border-yellow-400/30 rounded-lg">
            <option value="">-- Pilih --</option>
            @foreach ($options as $opt)
                <option value="{{ $opt }}" {{ old($name) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
            @endforeach
        </select>
        @error($name) <p class="text-sm text-red-400 mb-3">{{ $message }}</p> @enderror
    @endforeach

    {{-- Submit --}}
    <button type="submit" class="w-full py-2 mt-4 bg-yellow-400 text-blue-900 font-semibold rounded-full hover:bg-yellow-300 transition">Daftar</button>

    <p class="text-sm text-center text-white mt-4">
        Sudah punya akun? <a href="{{ route('login') }}" class="text-yellow-300 hover:underline">Masuk di sini</a>
    </p>
</form>


    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const desaSearch = document.getElementById('desa_search');
            const desaResults = document.getElementById('desa_results');
            const idDesaInput = document.getElementById('id_desa');

            desaSearch.addEventListener('input', function () {
                const query = this.value;
                if (query.length < 3) {
                    desaResults.innerHTML = '';
                    desaResults.classList.add('hidden');
                    return;
                }

                fetch(`/api/search-desa?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        desaResults.innerHTML = '';
                        if (data.length === 0) {
                            desaResults.classList.add('hidden');
                            return;
                        }

                        data.forEach(item => {
                            const li = document.createElement('li');
                            li.textContent = `${item.nama} - ${item.kecamatan} - ${item.kabupaten} - ${item.provinsi}`;
                            li.classList.add('cursor-pointer', 'px-4', 'py-2', 'hover:bg-sky-700');
                            li.addEventListener('click', () => {
                                desaSearch.value = li.textContent;
                                idDesaInput.value = item.id;
                                desaResults.classList.add('hidden');

                                fetch(`/api/desa/${item.id}`)
                                    .then(res => res.json())
                                    .then(data => {
                                        ['provinsi','kabupaten','kecamatan','desa','kode_desa'].forEach(field => {
                                            document.getElementById(field).value = data[field] ?? '';
                                        });
                                    });
                            });
                            desaResults.appendChild(li);
                        });

                        desaResults.classList.remove('hidden');
                    });
            });

            document.addEventListener('click', (e) => {
                if (!desaSearch.contains(e.target) && !desaResults.contains(e.target)) {
                    desaResults.classList.add('hidden');
                }
            });

            const oldIdDesa = '{{ old('id_desa') }}';
            if (oldIdDesa) {
                fetch(`/api/desa/${oldIdDesa}`)
                    .then(res => res.json())
                    .then(data => {
                        ['provinsi','kabupaten','kecamatan','desa','kode_desa'].forEach(field => {
                            document.getElementById(field).value = data[field] ?? '';
                        });

                        document.getElementById('desa_search').value =
                            `${data.desa} - ${data.kecamatan} - ${data.kabupaten} - ${data.provinsi}`;
                    });
            }
        });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // Validasi Bahasa Indonesia
        const form = document.getElementById('registerForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                let valid = true;

                // Validasi input kosong
                form.querySelectorAll('input[required], textarea[required], select[required]').forEach(input => {
                    input.setCustomValidity('');
                    if (!input.value) {
                        input.setCustomValidity('Harap isi bidang ini.');
                        input.reportValidity();
                        valid = false;
                    }
                });

                // Validasi konfirmasi password
                const password = document.getElementById('password');
                const confirm = document.getElementById('password_confirmation');
                if (password && confirm && password.value !== confirm.value) {
                    confirm.setCustomValidity('Konfirmasi kata sandi tidak cocok.');
                    confirm.reportValidity();
                    valid = false;
                }

                if (!valid) e.preventDefault();
            });
        }
    });
</script>


</body>
</html>
