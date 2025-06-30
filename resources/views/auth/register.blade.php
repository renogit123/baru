<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Portal Kemendagri</title>
    <link rel="icon" href="{{ asset('img/Subtract.png') }}" type="image/png">
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
            <img src="{{ asset('img/Subtract.png') }}" alt="Logo Kemendagri" class="mx-auto w-16 mb-3 drop-shadow-md">
            <h2 class="text-2xl font-bold">Pendaftaran Pengguna</h2>
            <p class="text-sm text-white/90">Silakan isi formulir untuk membuat akun Anda</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Akun --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-white">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full mt-1 px-4 py-2 rounded-lg bg-white/90 text-gray-900 focus:ring-2 focus:ring-yellow-400">
                @error('name') <span class="text-red-200 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-white">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="w-full mt-1 px-4 py-2 rounded-lg bg-white/90 text-gray-900 focus:ring-2 focus:ring-yellow-400">
                @error('email') <span class="text-red-200 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-white">Kata Sandi</label>
                <input type="password" id="password" name="password" required
                    class="w-full mt-1 px-4 py-2 rounded-lg bg-white/90 text-gray-900 focus:ring-2 focus:ring-yellow-400">
                @error('password') <span class="text-red-200 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-white">Konfirmasi Kata Sandi</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full mt-1 px-4 py-2 rounded-lg bg-white/90 text-gray-900 focus:ring-2 focus:ring-yellow-400">
            </div>

            {{-- Form Biodata --}}
            <x-input-label for="nama" value="Nama Peserta" class="text-white" />
            <x-text-input name="nama" id="nama" class="block w-full mb-4 bg-sky-900 text-white" value="{{ old('nama') }}" />

            <x-input-label for="alamat" value="Alamat" class="text-white" />
            <textarea name="alamat" id="alamat" class="block w-full mb-4 bg-sky-900 text-white rounded">{{ old('alamat') }}</textarea>

            <x-input-label for="id_desa" value="Desa/Kelurahan (pilih dari daftar)" class="text-white" />
            <input list="daftar-desa" name="id_desa" id="id_desa"
                class="block w-full mb-4 bg-sky-900 text-white placeholder-white/50"
                placeholder="contoh: desa/kel kec kab/kota prov" value="{{ old('id_desa') }}">
            <datalist id="daftar-desa">
                @foreach($kelurahans as $desa)
                    <option value="{{ $desa->id }}">
                        {{ $desa->nama }} - {{ $desa->kecamatan->nama ?? '' }} - {{ $desa->kecamatan->kabupatenKota->nama ?? '' }} - {{ $desa->kecamatan->kabupatenKota->provinsi->nama ?? '' }}
                    </option>
                @endforeach
            </datalist>

            <x-input-label value="Provinsi" class="text-white" />
            <input type="text" id="provinsi" name="provinsi" readonly class="block w-full mb-2 bg-sky-800 text-white">

            <x-input-label value="Kabupaten" class="text-white" />
            <input type="text" id="kabupaten" name="kabupaten" readonly class="block w-full mb-2 bg-sky-800 text-white">

            <x-input-label value="Kecamatan" class="text-white" />
            <input type="text" id="kecamatan" name="kecamatan" readonly class="block w-full mb-2 bg-sky-800 text-white">

            <x-input-label value="Kelurahan" class="text-white" />
            <input type="text" id="desa" name="kelurahan" readonly class="block w-full mb-2 bg-sky-800 text-white">

            <x-input-label value="Kode Desa" class="text-white" />
            <input type="text" id="kode_desa" name="kode_desa" readonly class="block w-full mb-4 bg-sky-800 text-white">

            <x-input-label for="nik" value="NIK" class="text-white" />
            <x-text-input name="nik" id="nik" class="block w-full mb-4 bg-sky-900 text-white" value="{{ old('nik') }}" />

            <x-input-label for="npwp" value="NPWP (opsional)" class="text-white" />
            <x-text-input name="npwp" id="npwp" class="block w-full mb-4 bg-sky-900 text-white" value="{{ old('npwp') }}" />

            <x-input-label for="tempat_lahir" value="Tempat Lahir" class="text-white" />
            <x-text-input name="tempat_lahir" id="tempat_lahir" class="block w-full mb-4 bg-sky-900 text-white" value="{{ old('tempat_lahir') }}" />

            <x-input-label for="tanggal_lahir" value="Tanggal Lahir" class="text-white" />
            <x-text-input name="tanggal_lahir" id="tanggal_lahir" type="date" class="block w-full mb-4 bg-sky-900 text-white" value="{{ old('tanggal_lahir') }}" />

            <x-input-label for="jenis_kelamin" value="Jenis Kelamin" class="text-white" />
            <select name="jenis_kelamin" class="block w-full mb-4 bg-sky-900 text-white rounded">
                <option value="">-- Pilih --</option>
                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>

            <x-input-label for="agama" value="Agama" class="text-white" />
            <select name="agama" class="block w-full mb-4 bg-sky-900 text-white rounded">
                <option value="">-- Pilih --</option>
                @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu','Lainnya'] as $agama)
                    <option value="{{ $agama }}" {{ old('agama') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                @endforeach
            </select>

            <x-input-label for="status_kawin" value="Status Kawin" class="text-white" />
            <select name="status_kawin" class="block w-full mb-4 bg-sky-900 text-white rounded">
                <option value="">-- Pilih --</option>
                @foreach(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
                    <option value="{{ $status }}" {{ old('status_kawin') == $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>

            <x-input-label for="jabatan" value="Jabatan" class="text-white" />
            <x-text-input name="jabatan" id="jabatan" class="block w-full mb-4 bg-sky-900 text-white" value="{{ old('jabatan') }}" />

            <x-input-label for="lama_menjabat" value="Lama Menjabat (tahun)" class="text-white" />
            <x-text-input name="lama_menjabat" id="lama_menjabat" type="number" class="block w-full mb-4 bg-sky-900 text-white" value="{{ old('lama_menjabat') }}" />

            <x-input-label for="nomor_sk_jabatan" value="Nomor SK Jabatan" class="text-white" />
            <x-text-input name="nomor_sk_jabatan" id="nomor_sk_jabatan" class="block w-full mb-4 bg-sky-900 text-white" value="{{ old('nomor_sk_jabatan') }}" />

            <x-input-label for="pendidikan" value="Pendidikan" class="text-white" />
            <select name="pendidikan" class="block w-full mb-4 bg-sky-900 text-white rounded">
                <option value="">-- Pilih --</option>
                @foreach(['SD', 'SMP', 'SMA', 'Diploma', 'Sarjana', 'Magister', 'Doktor', 'Lainnya'] as $edu)
                    <option value="{{ $edu }}" {{ old('pendidikan') == $edu ? 'selected' : '' }}>{{ $edu }}</option>
                @endforeach
            </select>

            <x-input-label for="no_telp" value="No Telepon" class="text-white" />
            <x-text-input name="no_telp" id="no_telp" class="block w-full mb-6 bg-sky-900 text-white" value="{{ old('no_telp') }}" />

            <button type="submit" class="w-full py-2 bg-yellow-400 text-blue-900 font-semibold rounded-full hover:bg-yellow-300 transition">Daftar</button>

            <p class="text-sm text-center text-white mt-4">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-yellow-300 hover:underline">Masuk di sini</a>
            </p>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const idDesaInput = document.getElementById('id_desa');

            idDesaInput.addEventListener('change', () => {
                const id = idDesaInput.value;
                if (!id) return;

                fetch(`/api/desa/${id}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('provinsi').value = data.provinsi ?? '';
                        document.getElementById('kabupaten').value = data.kabupaten ?? '';
                        document.getElementById('kecamatan').value = data.kecamatan ?? '';
                        document.getElementById('desa').value = data.desa ?? '';
                        document.getElementById('kode_desa').value = data.kode_desa ?? '';
                    });
            });

            const oldIdDesa = '{{ old('id_desa') }}';
            if (oldIdDesa) {
                fetch(`/api/desa/${oldIdDesa}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('provinsi').value = data.provinsi ?? '';
                        document.getElementById('kabupaten').value = data.kabupaten ?? '';
                        document.getElementById('kecamatan').value = data.kecamatan ?? '';
                        document.getElementById('desa').value = data.desa ?? '';
                        document.getElementById('kode_desa').value = data.kode_desa ?? '';
                    });
            }
        });
    </script>

</body>
</html>
