<x-user-layout>
    <div class="max-w-4xl mx-auto p-6 rounded-xl shadow-lg bg-sky-950 text-white ring-1 ring-white/10 animate-fade-in space-y-8">

    {{-- Kembali ke Dashboard --}}
    <a href="{{ route('user.dashboard') }}"
   class="inline-flex items-center gap-2 text-sm font-medium text-yellow-300 hover:text-yellow-200 transition-all group mb-6">
    <svg class="w-4 h-4 text-yellow-300 group-hover:translate-x-[-2px] transition-transform" fill="none" stroke="currentColor" stroke-width="2"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
    </svg>
    <span class="underline-offset-2 group-hover:underline">Kembali ke Dashboard</span>
</a>


    {{-- Judul Form --}}
    <div class="text-center space-y-1">
        <h2 class="text-3xl font-extrabold text-yellow-300 tracking-wide">📋 Formulir Biodata</h2>
        <p class="text-white/70 text-sm">Silakan isi data berikut dengan lengkap dan benar.</p>
    </div>

    {{-- Alert Sukses --}}
    @if(session('success'))
        <div class="mb-4 text-green-300 font-semibold bg-green-900/40 p-2 rounded border border-green-600">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Form --}}
    <form method="POST" action="{{ route('user.biodata.store') }}" class="space-y-6">
        @csrf

        <fieldset class="border border-white/10 rounded-xl p-4">
            <legend class="px-2 text-yellow-300 font-semibold text-sm uppercase">🧑 Informasi Pribadi</legend>

            {{-- Nama, Alamat --}}
            <x-input-label for="nama" value="Nama Peserta" class="text-white mt-4" />
            <x-text-input name="nama" id="nama" type="text"
                class="w-full bg-sky-900 border border-white/20 text-white"
                value="{{ old('nama', $biodata->nama ?? '') }}" />

            <x-input-label for="alamat" value="Alamat" class="text-white mt-4" />
            <textarea name="alamat" id="alamat"
                class="w-full bg-sky-900 border border-white/20 text-white rounded">{{ old('alamat', $biodata->alamat ?? '') }}</textarea>

            {{-- Tempat & Tanggal Lahir --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <x-input-label for="tempat_lahir" value="Tempat Lahir" class="text-white" />
                    <x-text-input name="tempat_lahir" id="tempat_lahir" type="text"
                        class="w-full bg-sky-900 border border-white/20 text-white"
                        value="{{ old('tempat_lahir', $biodata->tempat_lahir ?? '') }}" />
                </div>
                <div>
                    <x-input-label for="tanggal_lahir" value="Tanggal Lahir" class="text-white" />
                    <x-text-input name="tanggal_lahir" id="tanggal_lahir" type="date"
                        class="w-full bg-sky-900 border border-white/20 text-white"
                        value="{{ old('tanggal_lahir', $biodata->tanggal_lahir ?? '') }}" />
                </div>
            </div>
        </fieldset>

        {{-- Divider --}}
        <hr class="border-white/10 my-6">

        <fieldset class="border border-white/10 rounded-xl p-4">
            <legend class="px-2 text-yellow-300 font-semibold text-sm uppercase">🏡 Informasi Wilayah</legend>

            {{-- Input ID Desa dengan autocomplete --}}
            <x-input-label for="id_desa" value="ID Desa (pilih dari daftar)" class="text-white mt-4" />
            <input list="daftar-desa" name="id_desa" id="id_desa"
                class="w-full bg-sky-900 border border-white/20 text-white rounded placeholder-white/50"
                placeholder="Cari desa/kelurahan..."
                value="{{ old('id_desa', $biodata->id_desa ?? '') }}" required>
            <datalist id="daftar-desa">
                @foreach($kelurahans as $desa)
                    <option value="{{ $desa->id }}">{{ $desa->nama }} - {{ optional($desa->kecamatan)->nama }}</option>
                @endforeach
            </datalist>

            {{-- Otomatis Wilayah --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <input readonly id="provinsi" name="provinsi" placeholder="Provinsi"
                    class="bg-sky-800 border border-white/20 text-white rounded px-3 py-2" />
                <input readonly id="kabupaten" name="kabupaten" placeholder="Kabupaten"
                    class="bg-sky-800 border border-white/20 text-white rounded px-3 py-2" />
                <input readonly id="kecamatan" name="kecamatan" placeholder="Kecamatan"
                    class="bg-sky-800 border border-white/20 text-white rounded px-3 py-2" />
                <input readonly id="desa" name="desa" placeholder="Desa"
                    class="bg-sky-800 border border-white/20 text-white rounded px-3 py-2" />
            </div>
        </fieldset>

        {{-- Divider --}}
        <hr class="border-white/10 my-6">

        <fieldset class="border border-white/10 rounded-xl p-4">
            <legend class="px-2 text-yellow-300 font-semibold text-sm uppercase">📑 Informasi Tambahan</legend>

            {{-- NIK, NPWP --}}
            <x-input-label for="nik" value="NIK" class="text-white mt-4" />
            <x-text-input name="nik" id="nik" type="text"
                class="w-full bg-sky-900 border border-white/20 text-white"
                value="{{ old('nik', $biodata->nik ?? '') }}" />

            <x-input-label for="npwp" value="NPWP (opsional)" class="text-white mt-4" />
            <x-text-input name="npwp" id="npwp" type="text"
                class="w-full bg-sky-900 border border-white/20 text-white"
                value="{{ old('npwp', $biodata->npwp ?? '') }}" />

            {{-- Pendidikan & Jabatan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <x-input-label for="pendidikan" value="Pendidikan" class="text-white" />
                    <select name="pendidikan" id="pendidikan"
                        class="w-full bg-sky-900 border border-white/20 text-white rounded">
                        <option value="">-- Pilih --</option>
                        @foreach(['SD', 'SMP', 'SMA', 'Diploma', 'Sarjana', 'Magister', 'Doktor'] as $edu)
                            <option value="{{ $edu }}" {{ old('pendidikan', $biodata->pendidikan ?? '') == $edu ? 'selected' : '' }}>{{ $edu }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <x-input-label for="jabatan" value="Jabatan" class="text-white" />
                    <x-text-input name="jabatan" id="jabatan" type="text"
                        class="w-full bg-sky-900 border border-white/20 text-white"
                        value="{{ old('jabatan', $biodata->jabatan ?? '') }}" />
                </div>
            </div>
        </fieldset>

        {{-- Tombol Simpan --}}
        <div class="pt-6 text-center">
            <x-primary-button class="bg-yellow-400 text-sky-900 hover:bg-yellow-300 font-bold px-8 py-3 rounded-xl shadow-md transition-all hover:-translate-y-1">
                💾 Simpan Biodata
            </x-primary-button>
        </div>
    </form>
</div>

    
</x-user-layout>
