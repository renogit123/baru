<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengguna - Kemendagri</title>
    <link rel="icon" href="{{ asset('img/logokemendagri-fix.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, #0a1f44, #1e40af);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center text-white px-4 py-10">

    {{-- Tombol Kembali --}}
<a href="{{ url('/') }}"
   class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 text-white text-sm font-medium shadow hover:bg-yellow-400 hover:text-blue-900 hover:shadow-lg transition duration-300 absolute top-6 left-6 backdrop-blur-sm">
   <svg class="w-4 h-4 transition-transform duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor"
        stroke-width="2" viewBox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
   </svg>
   <span class="hidden sm:inline">Kembali ke Beranda</span>
</a>


{{-- Card Form --}}
<div class="w-full max-w-5xl mx-auto rounded-xl shadow-2xl backdrop-blur-md bg-white/10 border border-white/20 p-10 animate-fade-in">
    <div class="text-center mb-10">
        <img src="{{ asset('img/logokemendagri-fix.png') }}" class="w-16 mx-auto mb-3 drop-shadow-lg animate-fade-in" alt="Logo">
        <h1 class="text-3xl md:text-4xl font-extrabold text-yellow-400 tracking-tight mb-1">Formulir Pendaftaran</h1>
        <p class="text-sm md:text-base text-white/80">Silakan lengkapi data akun dan biodata Anda dengan lengkap</p>
    </div>


        <form method="POST" action="{{ route('register') }}">
    @csrf

    {{-- === Informasi Akun === --}}
    <h3 class="text-lg font-semibold text-yellow-300 mb-3">Informasi Akun</h3>
    <div class="grid md:grid-cols-2 gap-6 mb-10">
        <div class="space-y-4">
            <label for="name" class="block text-sm font-semibold text-white">Nama Lengkap</label>
            <input type="text" name="name" id="name" required value="{{ old('name') }}"
                class="w-full px-4 py-2 bg-white text-gray-900 rounded-lg focus:ring-2 focus:ring-yellow-400">

            <label for="email" class="block text-sm font-semibold text-white">Email</label>
            <input type="email" name="email" id="email" required value="{{ old('email') }}"
                class="w-full px-4 py-2 bg-white text-gray-900 rounded-lg focus:ring-2 focus:ring-yellow-400">
        </div>

        <div class="space-y-4">
            <label for="password" class="block text-sm font-semibold text-white">Kata Sandi</label>
            <input type="password" name="password" id="password" required
                class="w-full px-4 py-2 bg-white text-gray-900 rounded-lg focus:ring-2 focus:ring-yellow-400">

            <label for="password_confirmation" class="block text-sm font-semibold text-white">Konfirmasi Sandi</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                class="w-full px-4 py-2 bg-white text-gray-900 rounded-lg focus:ring-2 focus:ring-yellow-400">
        </div>
    </div>

    {{-- === Biodata Peserta === --}}
    <h3 class="text-lg font-semibold text-yellow-300 mb-3">Biodata Peserta</h3>
    <div class="grid md:grid-cols-2 gap-6">
        {{-- Kolom Kiri --}}
        <div class="space-y-4">
            <x-input-label for="nama" value="Nama Peserta" class="text-white font-semibold" />
            <x-text-input name="nama" id="nama" class="w-full bg-sky-900 text-white" value="{{ old('nama') }}" />

            <x-input-label for="alamat" value="Alamat" class="text-white font-semibold" />
            <textarea name="alamat" id="alamat" class="w-full bg-sky-900 text-white rounded">{{ old('alamat') }}</textarea>

            <x-input-label for="id_desa" value="Desa/Kelurahan" class="text-white font-semibold" />
            <input list="daftar-desa" name="id_desa" id="id_desa"
                class="w-full bg-sky-900 text-white placeholder-white/50 rounded"
                placeholder="Pilih dari daftar" value="{{ old('id_desa') }}">
            <datalist id="daftar-desa">
                @foreach($kelurahans as $desa)
                    <option value="{{ $desa->id }}">
                        {{ $desa->nama }} - {{ $desa->kecamatan->nama ?? '' }} - {{ $desa->kecamatan->kabupatenKota->nama ?? '' }} - {{ $desa->kecamatan->kabupatenKota->provinsi->nama ?? '' }}
                    </option>
                @endforeach
            </datalist>

            <x-input-label value="Provinsi" class="text-white font-semibold" />
            <input type="text" id="provinsi" name="provinsi" readonly class="w-full bg-sky-800 text-white rounded">

            <x-input-label value="Kabupaten" class="text-white font-semibold" />
            <input type="text" id="kabupaten" name="kabupaten" readonly class="w-full bg-sky-800 text-white rounded">

            <x-input-label value="Kecamatan" class="text-white font-semibold" />
            <input type="text" id="kecamatan" name="kecamatan" readonly class="w-full bg-sky-800 text-white rounded">

            <x-input-label value="Kelurahan" class="text-white font-semibold" />
            <input type="text" id="desa" name="kelurahan" readonly class="w-full bg-sky-800 text-white rounded">

            <x-input-label value="Kode Desa" class="text-white font-semibold" />
            <input type="text" id="kode_desa" name="kode_desa" readonly class="w-full bg-sky-800 text-white rounded">
        </div>

        {{-- Kolom Kanan --}}
        <div class="space-y-4">
            <x-input-label for="nik" value="NIK" class="text-white font-semibold" />
            <x-text-input name="nik" id="nik" class="w-full bg-sky-900 text-white" value="{{ old('nik') }}" />

            <x-input-label for="npwp" value="NPWP (opsional)" class="text-white font-semibold" />
            <x-text-input name="npwp" id="npwp" class="w-full bg-sky-900 text-white" value="{{ old('npwp') }}" />

            <x-input-label for="tempat_lahir" value="Tempat Lahir" class="text-white font-semibold" />
            <x-text-input name="tempat_lahir" id="tempat_lahir" class="w-full bg-sky-900 text-white" value="{{ old('tempat_lahir') }}" />

            <x-input-label for="tanggal_lahir" value="Tanggal Lahir" class="text-white font-semibold" />
            <x-text-input name="tanggal_lahir" id="tanggal_lahir" type="date" class="w-full bg-sky-900 text-white" value="{{ old('tanggal_lahir') }}" />

            <x-input-label for="jenis_kelamin" value="Jenis Kelamin" class="text-white font-semibold" />
            <select name="jenis_kelamin" class="w-full bg-sky-900 text-white rounded">
                <option value="">-- Pilih --</option>
                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>

            <x-input-label for="agama" value="Agama" class="text-white font-semibold" />
            <select name="agama" class="w-full bg-sky-900 text-white rounded">
                <option value="">-- Pilih --</option>
                @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu','Lainnya'] as $agama)
                    <option value="{{ $agama }}" {{ old('agama') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                @endforeach
            </select>

            <x-input-label for="status_kawin" value="Status Kawin" class="text-white font-semibold" />
            <select name="status_kawin" class="w-full bg-sky-900 text-white rounded">
                <option value="">-- Pilih --</option>
                @foreach(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
                    <option value="{{ $status }}" {{ old('status_kawin') == $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>

            <x-input-label for="jabatan" value="Jabatan" class="text-white font-semibold" />
            <x-text-input name="jabatan" id="jabatan" class="w-full bg-sky-900 text-white" value="{{ old('jabatan') }}" />

            <x-input-label for="lama_menjabat" value="Lama Menjabat (tahun)" class="text-white font-semibold" />
            <x-text-input name="lama_menjabat" id="lama_menjabat" type="number" class="w-full bg-sky-900 text-white" value="{{ old('lama_menjabat') }}" />

            <x-input-label for="nomor_sk_jabatan" value="Nomor SK Jabatan" class="text-white font-semibold" />
            <x-text-input name="nomor_sk_jabatan" id="nomor_sk_jabatan" class="w-full bg-sky-900 text-white" value="{{ old('nomor_sk_jabatan') }}" />

            <x-input-label for="pendidikan" value="Pendidikan" class="text-white font-semibold" />
            <select name="pendidikan" class="w-full bg-sky-900 text-white rounded">
                <option value="">-- Pilih --</option>
                @foreach(['SD', 'SMP', 'SMA', 'Diploma', 'Sarjana', 'Magister', 'Doktor', 'Lainnya'] as $edu)
                    <option value="{{ $edu }}" {{ old('pendidikan') == $edu ? 'selected' : '' }}>{{ $edu }}</option>
                @endforeach
            </select>

            <x-input-label for="no_telp" value="No Telepon" class="text-white font-semibold" />
            <x-text-input name="no_telp" id="no_telp" class="w-full bg-sky-900 text-white" value="{{ old('no_telp') }}" />
        </div>
    </div>

    {{-- Tombol Submit --}}
    <div class="mt-10">
        <button type="submit" class="w-full py-3 bg-yellow-400 text-blue-900 font-semibold rounded-full hover:bg-yellow-300 transition-all">
            Daftar Sekarang
        </button>
        <p class="text-sm text-center text-white mt-4">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-yellow-300 hover:underline">Masuk di sini</a>
        </p>
    </div>
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
        });
    </script>

</body>
</html>
